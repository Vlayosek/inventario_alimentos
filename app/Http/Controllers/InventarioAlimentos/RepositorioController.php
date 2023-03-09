<?php

namespace App\Http\Controllers\InventarioAlimentos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Ajax\SelectController;
use App\Core\Entities\InventarioAlimentos\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Core\Entities\InventarioAlimentos\Necesidad;
use App\Core\Entities\InventarioAlimentos\Transaccion;
use App\Core\Entities\InventarioAlimentos\Producto;
use App\Core\Entities\TalentoHumano\Distributivo\Persona;
use App\Core\Entities\InventarioAlimentos\EstadoNecesidad;
use App\Core\Entities\InventarioAlimentos\Estado;


class RepositorioController extends Controller
{
  protected $TABLA = 'productos';
  protected $MODULO = 'INVENTARIO ALIMENTOS';
  public function  inactivarTransaccionAnterior($id, $tipo)
  {
    $cqlTransaccionD_ = Transaccion::where('producto_id', $id)
      ->where('tipo_transaccion', $tipo)
      ->orderby('id', 'desc')->first();

    if (!is_null($cqlTransaccionD_)) {
      $cqlTransaccionD_->ultima_transaccion = false;
      $cqlTransaccionD_->estado = 'INA';
      $cqlTransaccionD_->save();
    }
    return true;
  }

  public function selectDatatable()
  {
    return Necesidad::select(
      'necesidades.id',
      'necesidades.persona_id',
      'necesidades.fecha_solicitud',
      'necesidades.observacion',
      'necesidades.aceptada',
      'necesidades.historia_laboral_id',
      'necesidades.fecha_inserta as fecha_solicitud',
      'necesidades.eliminado',
      'necesidades.usuario_inserta',
      'necesidades.usuario_modifica',
      'necesidades.usuario_id_inserta',
      'necesidades.fecha_modifica',
      'est.descripcion as estado',
      'user.nombres as solicitante'
    )
      ->leftjoin('sc_inventario_alimentos.estados_necesidades as est', function ($join) {
        $join->on('est.tabla_id', 'necesidades.id')
          ->where('est.estado', 'ACT');
      })->join('core.users as user', 'user.identificacion', 'necesidades.usuario_id_inserta');
  }

  public function filtrosFechasConsultaEstado($query, $inicio, $fin, $estado)
  {
    if (!is_array($estado)) $estado = [$estado];
    return $query
      ->whereDate('est.fecha_inserta', '>=', $inicio)
      ->whereDate('est.fecha_inserta', '<=', $fin)
      ->where(function ($query) use ($estado) {
        $query->select(DB::RAW('COUNT(est_solicitud.id)'))
          ->from('sc_inventario_alimentos.estados_necesidades as est_solicitud')
          ->whereColumn('est_solicitud.tabla_id', 'necesidades.id')
          ->where('est_solicitud.eliminado', false)
          ->where('est_solicitud.estado', 'ACT')
          ->whereIn('est_solicitud.descripcion', $estado);
      }, '>', 0)
      ->where('necesidades.eliminado', false);
  }

  public function filtrosFechasConsultaEstadoPendiente($query, $estado, $fechaPeriodo = null)
  {
    if (!is_array($estado)) $estado = [$estado];
    return $query
      ->where(function ($query) use ($estado) {
        $query->select(DB::RAW('COUNT(est_solicitud.id)'))
          ->from('sc_inventario_alimentos.estados_necesidades as est_solicitud')
          ->whereColumn('est_solicitud.tabla_id', 'necesidades.id')
          ->where('est_solicitud.eliminado', false)
          ->where('est_solicitud.descripcion', $estado)
          ->where('est_solicitud.estado', 'ACT');
      }, '>', 0)
      ->where('necesidades.eliminado', false);
  }

  public function nuevaTransaccion($producto, $cantidad, $stock, $tipo)
  {
    $cqlProducto = Producto::select('id')->where('producto', $producto)->first();
    $this->inactivarTransaccionAnterior($cqlProducto->id, $tipo);
    $cqlTransaccion = new Transaccion();
    $cqlTransaccion->descripcion = $tipo . ' DE ' . $producto;
    $cqlTransaccion->producto_id =  $cqlProducto->id;
    $cqlTransaccion->fecha_inserta = date('Y-m-d H:i:s');
    $cqlTransaccion->usuario_inserta =  Auth::user()->name;
    $cqlTransaccion->cantidad =  $cantidad;
    $cqlTransaccion->stock_disponible =  $stock;
    $cqlTransaccion->tipo_transaccion =  $tipo;
    $cqlTransaccion->ultima_transaccion = true;
    $cqlTransaccion->save();
  }

  public function consultaPersona($tipo, $identificacion)
  {
    if ($tipo == "generar") {
      $data = Persona::select(
        'personas.id as persona_id',
        'hs.id as historia_laboral_id',
        'personas.identificacion',
        'personas.apellidos_nombres',
        'crg.nombre as cargo',
        'area.nombre as unidad_administrativa',
      );
    }
    if ($tipo == "editar") {
      $data = Persona::select(
        'personas.apellidos_nombres',
        'area.nombre as unidad_administrativa',
        'crg.nombre as cargo'
      );
    }
    $data = $data
      ->join('sc_distributivo_.historias_laborales as hs', 'hs.persona_id', 'personas.id')
      ->leftjoin('sc_distributivo_.areas as area', 'area.id', 'hs.area_id')
      ->leftjoin('sc_distributivo_.cargos as crg', 'crg.id', 'hs.cargo_id')
      ->where('personas.identificacion', $identificacion)
      ->where('personas.estado', 'ACT')
      ->where('personas.eliminado', false)
      ->where('hs.estado', 'ACT')
      ->where('hs.eliminado_por_reingreso', false)
      ->first();

    return $data;
  }
  public function consultaStock($id)
  {
    $consultaStockCompra = Transaccion::where('producto_id', $id)
      ->where('tipo_transaccion', 'COMPRA')->sum('cantidad');

    $consultaStockSalida = Transaccion::where('producto_id', $id)
      ->where('tipo_transaccion', 'SALIDA')->sum('cantidad');

    $consultaStockDevoluciones = Transaccion::where('producto_id', $id)
      ->where('tipo_transaccion', 'DEVOLUCION')->sum('cantidad');

    $array['stock'] = $consultaStockCompra + $consultaStockDevoluciones - $consultaStockSalida;
    $array['stock_salida'] = $consultaStockSalida - $consultaStockDevoluciones;
    return $array;
  }
  public function verificarCambios($request, $consulta, $excepciones = [])
  {
    $arregloObservacion = [];
    if ($request['id'] != 0) {
      $excepcionAuditoria = ['id', 'eliminado', 'fecha_modifica', 'fecha_inserta', 'usuario_inserta', 'usuario_modifica'];
      $request = $request->except(array_merge($excepcionAuditoria, $excepciones));
      foreach ($request as $key => $value) {
        // dd($consulta->attributes,isset($consulta->{$key}));
        if (isset($consulta->{$key}) && !is_array($value)) {
          if ($consulta[$key] != $value) {
            $arregloObservacion[$key]['anterior'] = $consulta[$key];
            $arregloObservacion[$key]['actual'] = $value;
          }
        }
      }
    }
    return $arregloObservacion;
  }
  public function guardarLogs($arregloCambios, $id, $tabla = null)
  {
    if (is_null($tabla))  $tabla = $this->TABLA;
    foreach ($arregloCambios as $key => $value) {
      $cqlInserta = new Log();

      $cqlInserta->usuario_inserta = Auth::user()->nombres;
      $cqlInserta->fecha_inserta = date('Y-m-d H:i:s');
      $cqlInserta->eliminado = false;
      $cqlInserta->tabla = $tabla;
      $cqlInserta->tabla_id = $id;
      $cqlInserta->campo = $key;
      $cqlInserta->anterior = $value['anterior'];
      $cqlInserta->actual = $value['actual'];
      $cqlInserta->save();
    }
  }
  public function selectDatatableNecesidades($filtro)
  {
    if ($filtro) {
      $cql = Necesidad::select(
        'necesidades.id',
      );
    } else {
      $cql = Necesidad::select(
        'necesidades.id',
        'necesidades.persona_id',
        'necesidades.fecha_solicitud',
        'necesidades.observacion',
        'necesidades.historia_laboral_id',
        'necesidades.usuario_id_inserta',
        'necesidades.aceptada',
        'estado_necesidad.descripcion as estado',
        'user.nombres as apellidos_nombres'
      );
    }
    $cql = $cql
      ->leftjoin('sc_inventario_alimentos.estados_necesidades as estado_necesidad', function ($join) {
        $join->on('estado_necesidad.tabla_id', 'necesidades.id')
          ->where('estado_necesidad.estado', 'ACT');
      })
      ->join('core.users as user', 'user.identificacion', 'necesidades.usuario_id_inserta')
      ->where('necesidades.eliminado', false)
      ->where('necesidades.estado', 'ACT');

    return $cql;
  }
  public function filtroSinFecha($query, $estado)
  {
    if (!is_array($estado)) $estado = [$estado];
    return $query
      ->where(function ($query) use ($estado) {
        $query->select(DB::RAW('COUNT(est_necesidad.id)'))
          ->from('sc_inventario_alimentos.estados_necesidades as est_necesidad')
          ->whereColumn('est_necesidad.tabla_id', 'necesidades.id')
          ->where('est_necesidad.eliminado', false)
          ->where('est_necesidad.estado', 'ACT')
          ->whereIn('est_necesidad.descripcion', $estado);
      }, '>', 0);
  }
  public function filtroConFecha($query, $inicio, $fin, $estado)
  {
    if (!is_array($estado)) $estado = [$estado];
    return $query
      ->whereDate('necesidades.fecha_solicitud', '>=', $inicio)
      ->whereDate('necesidades.fecha_solicitud', '<=', $fin)
      ->where(function ($query) use ($estado) {
        $query->select(DB::RAW('COUNT(est_necesidad.id)'))
          ->from('sc_inventario_alimentos.estados_necesidades as est_necesidad')
          ->whereColumn('est_necesidad.tabla_id', 'necesidades.id')
          ->where('est_necesidad.eliminado', false)
          ->where('est_necesidad.estado', 'ACT')
          ->whereIn('est_necesidad.descripcion', $estado);
      }, '>', 0);
  }

  public function guardarEstado($id, $descripcion, $observacion = '')
  {
    //dd($id, $descripcion, $observacion );
    $objSelect = new SelectController();
    $historial_ = $objSelect->buscarDatosUath(Auth::user()->identificacion);
    $cqlUpdate = EstadoNecesidad::where('tabla_id', $id)->update(['estado' => 'INA']);
    $estado_id = Estado::where('descripcion', $descripcion)->where('eliminado', false)->first()->id;
    $cqlInserta = new EstadoNecesidad();
    $cqlInserta->usuario_id_inserta = Auth::user()->identificacion;
    $cqlInserta->usuario_inserta = Auth::user()->nombres;
    $cqlInserta->fecha_inserta = date('Y-m-d H:i:s');
    $cqlInserta->descripcion = $descripcion;
    $cqlInserta->historia_laboral_id = $historial_['historia_laboral_id'];
    $cqlInserta->eliminado = false;
    $cqlInserta->tabla_id = $id;
    $cqlInserta->estado = 'ACT';
    $cqlInserta->observacion = $observacion != '' ? $observacion : $descripcion;
    $cqlInserta->estado_id = $estado_id;
    $cqlInserta->save();

    //$this->envioCorreo($descripcion, $id, (Solicitud::find($id))->usuario_id_inserta);
  }

  public function consultaEstadoActividad($id)
  {
    return EstadoNecesidad::select('descripcion')->where('estado', 'ACT')->where('eliminado', false)->where('tabla_id', $id)->first()->descripcion;
  }
}
