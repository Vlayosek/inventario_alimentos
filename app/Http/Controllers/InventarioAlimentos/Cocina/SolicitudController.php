<?php

namespace App\Http\Controllers\InventarioAlimentos\Cocina;

use App\Http\Controllers\InventarioAlimentos\RepositorioController as RP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\InventarioAlimentos\Producto;
use App\Core\Entities\InventarioAlimentos\Compra;
use App\Core\Entities\InventarioAlimentos\Salida;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Ajax\SelectController;
use App\Core\Entities\Admin\tb_parametro as Param;
use App\Core\Entities\InventarioAlimentos\Transaccion;
use App\Core\Entities\InventarioAlimentos\Necesidad;
use App\Core\Entities\InventarioAlimentos\NecesidadDetalle;
use DB;
use Auth;

class SolicitudController extends Controller
{
  public function necesidades()
  {
    $datos = new SelectController();
//    $medidas  = $datos->getParametro('MEDIDAS_INVENTARIO', 'http', 4);
//    $tipos  = $datos->getParametro('TIPOS_INVENTARIO', 'http', 4);
    $productos  = Producto::where('eliminado', false)->pluck('producto', 'producto')->toArray();

    return view('modules.inventario_alimentos.cocina.necesidad.index', compact(
      'productos',
    ));
  }

  public function datatableNecesidadesPOSTServerSide($fecha_inicio, $fecha_fin, $tipoActual)
  {
    $objRepo = new Rp();
    $data = $objRepo->selectDatatable()->where('necesidades.usuario_id_inserta', Auth::user()->identificacion);


    switch ($tipoActual) {
      case 'BORRADOR':
        $estado = 'BORRADOR';
        $data = $objRepo->filtrosFechasConsultaEstadoPendiente($data, $estado);
        break;
      case 'ENVIADO':
        $estado = ['PENDIENTE ACEPTAR'];
        break;
      case 'ACEPTADO':
        $estado = ['ACEPTADO CARONDELET'];
        break;
    }

    if ($tipoActual != "BORRADOR") {
      $data = $objRepo->filtrosFechasConsultaEstado($data, $fecha_inicio, $fecha_fin, $estado);
    }

    return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('reg', function ($row) {
        return 'REG' . ' - ' . $row->id;
      })
      ->addColumn('', function ($row) use ($tipoActual) {
        $btn = ' <table style="width:100%;border:0px">';
        $consulta = true;
        if ($tipoActual == 'BORRADOR') $consulta = false;

        if ($consulta) {
          $btn .= '<tr><td style="padding: 2px;border:0px;text-align:center;"><button class="btn btn-default btn-block btn-xs"  onclick="app.editarRegistro(\'' . $row->id . '\',\'' . $consulta . '\')" data-toggle="modal" data-target="#modal-SOLICITUD_INGRESO" data-backdrop="static" data-keyboard="false">&nbsp;VER SOLICITUD</button></td></tr>';
        } else {
          $btn .= '<tr><td style="padding: 2px;border:0px;text-align:center;"><button class="btn btn-primary btn-block btn-xs"  onclick="app.editarRegistro(\'' . $row->id . '\',\'' . $consulta . '\')" data-toggle="modal" data-target="#modal-SOLICITUD_INGRESO"><i class="fa fa-cog"></i>&nbsp;ADMINISTRAR</button></td>';
          $btn .= '<td style="padding: 2px;border:0px;text-align:center;"><button  class="btn btn-danger btn-block btn-xs"  onclick="app.eliminarRegistro(\'' . $row->id . '\',\'solicitud\')"><i class="fa fa-trash"></i></button></td></tr>';
        }
        if ($tipoActual != 'BORRADOR')
          $btn .= '<tr><td colspan="2" style="padding: 2px;border:0px;text-align:center;"><button  class="btn btn-info btn-block btn-xs"  onclick="app.seguimiento(\'' . $row->id . '\')" data-toggle="modal" data-target="#modal-seguimiento">SEGUIMIENTO</button></td></tr>';
        $btn .= ' </table>';
        return $btn;
      })
      ->rawColumns([''])
      ->make(true);
  }

  public function consultaEstadosNecesidades(Request $request)
  {
    $objRepo = new Rp();

    $fecha_inicio = $request->fecha_inicio;
    $fecha_fin = $request->fecha_fin;

    $estado = 'BORRADOR';
    $pendiente = $objRepo->filtrosFechasConsultaEstadoPendiente(clone $this->selectEstados(), $estado)->where('necesidades.eliminado', false);

    $estado = ['PENDIENTE ACEPTAR'];
    $enviada = $objRepo->filtrosFechasConsultaEstado(clone $this->selectEstados(), $fecha_inicio, $fecha_fin, $estado)->where('necesidades.eliminado', false);

    $estado = ['ACEPTADO CARONDELET'];
    $aprobado = $objRepo->filtrosFechasConsultaEstado(clone $this->selectEstados(), $fecha_inicio, $fecha_fin, $estado)->where('necesidades.eliminado', false);


    $array_response['status'] = 200;
    $array_response['pendientes'] = $pendiente->count('necesidades.id');
    $array_response['enviados'] = $enviada->count('necesidades.id');
    $array_response['aceptados'] = $aprobado->count('necesidades.id');
    return response()->json($array_response, 200);

  }

  protected function selectEstados()
  {
    return Necesidad::select(
      'necesidades.id'
    )->where('necesidades.usuario_id_inserta', Auth::user()->identificacion)
      ->join('sc_inventario_alimentos.estados_necesidades as est', function ($join) {
        $join->on('est.tabla_id', 'necesidades.id')
          ->where('est.estado', 'ACT');
      });
  }

  public function generarNecesidad(request $request)
  {
    $objRp = new Rp();
    $datos = $objRp->consultaPersona('generar', Auth::user()->identificacion);
    //$productos = $objRp->consultaProducto('generar', Auth::user()->identificacion);
    //generar solicitud
    try {
      DB::connection('pgsql_presidencia')->beginTransaction();
      $cql = new Necesidad();
      $cql->persona_id = $datos->persona_id;
      $cql->fecha_solicitud = date('Y-m-d H:i:s');
      $cql->historia_laboral_id = $datos->historia_laboral_id;
      $cql->estado = 'ACT';
      $cql->fecha_inserta = date('Y-m-d H:i:s');
      $cql->usuario_inserta = Auth::user()->name;
      $cql->usuario_id_inserta = $datos->identificacion;
      $cql->save();
      //guardar estado
      $objRp->guardarEstado($cql->id, 'BORRADOR', 'NECESIDAD GENERADA');
      $array_response['datos'] = $datos;
      $array_response['id'] = $cql->id;
      $array_response['status'] = 200;
      $array_response['message'] = "Necesidad generada con exito";
      DB::connection('pgsql_presidencia')->commit();
    } catch (\Exception $e) {
      DB::connection('pgsql_presidencia')->rollBack();
      $array_response['status'] = 404;
      $array_response['message'] = $e->getMessage();
    }
    return response()->json($array_response, 200);
  }

  public function getDatatableProductosServerSide($necesidad_id)
  {
    //dd($necesidad_id);
    $data = NecesidadDetalle::select(
      'necesidades_detalles.id',
      'necesidades_detalles.producto',
      'necesidades_detalles.cantidad',
      'necesidades_detalles.medida',
//      'transacciones.stock_disponible',
    )
//      ->join('sc_inventario_alimentos.transacciones','transacciones.descripcion','necesidades_detalles.producto')
      ->where('necesidades_detalles.necesidad_id',$necesidad_id)
      ->where('necesidades_detalles.estado','ACT')
      ->where('necesidades_detalles.eliminado',false)
      ->get();
    $objRp = new RP();

    $estado = $objRp->consultaEstadoActividad($necesidad_id);
//    $fecha = Necesidad::select('fecha_solicitud')->where('id',$necesidad_id)->first()->fecha_solicitud;
//    dd($fecha);

    return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('', function ($row) use ($estado){
//        if(is_null($fecha)){
          $btn = ' <table style="width:100%;border:0px">';
          //$btn .= '<tr><td style="padding: 2px"><button class="btn btn-default btn-block btn-xs"  onclick="app.editarRegistro(\'' . $row->id . '\',\'' . $consulta . '\')" data-toggle="modal" data-target="#modal-solicitud">&nbsp;VER SOLICITUD</button></td></tr>';
          if ($estado == "BORRADOR"){
            $btn .= '<tr><td style="padding: 2px;border:0px;text-align:center;"><button class="btn btn-primary btn-block btn-xs"  onclick="app.editarProducto(\'' . $row->id . '\')" data-toggle="modal" data-target="#modal-solicitud"><i class="fa fa-cog"></i>&nbsp;EDITAR</button></td>';
            $btn .= '<td style="padding: 2px;border:0px;text-align:center;"><button  class="btn btn-danger btn-block btn-xs"  onclick="app.eliminarProducto(\'' . $row->id . '\',\'actividad\')"><i class="fa fa-trash"></i></button></td></tr>';
          }
          $btn .= ' </table>';
          return $btn;
//        }
      })
      ->rawColumns([''])
      ->make(true);
  }

  public function eliminarProducto(Request $request)
  {
    try {
      DB::connection('pgsql_presidencia')->beginTransaction();

      /* $cql = Transaccion::where('producto_id', $request->id)->where('tipo_transaccion', 'COMPRA')->where('stock_disponible', '>', 0)->first();

      if (!is_null($cql)) throw new \Exception("NO PUEDE ELIMINAR PORQUE EL PRODUCTO CONTIENE STOCK"); */


      $cql = Producto::find($request->id);
      $cql->fecha_modifica = date('Y-m-d H:i:s');
      $cql->usuario_modifica = Auth::user()->name;
      $cql->observacion_eliminacion = $request->observacion;
      $cql->eliminado = true;
      $cql->estado = 'ACT';
      $cql->save();

      DB::connection('pgsql_presidencia')->commit();
      $array_response['status'] = 200;
      $array_response['message'] = "Grabado Exitoso";
      $array_response['id'] = $cql->id;
    } catch (\Exception $e) {
      DB::connection('pgsql_presidencia')->rollBack();
      $array_response['status'] = 404;
      $array_response['message'] = $e->getMessage();
    }
    return response()->json($array_response, 200);
  }

  protected function consultaProducto($descripcion)
  {
    $cql = Producto::where('producto', $descripcion)->where('estado', 'ACT')->where('eliminado', false)->first();
    return !is_null($cql);
  }

  public function guardarProducto(Request $request)
  {
    $producto = strtoupper($request->producto);
    $objSelectRepositorio = new RepositorioController();
    $objSelect = new SelectController();
    $cambios = [];
    //* TODO Consultamos si y existe el producto
    $validaCompra = $this->consultaProducto($producto);

    if ($request->id == '0' && $validaCompra) {
      $array_response['status'] = 300;
      $array_response['message'] = "Producto " . $producto . " ya existe.";
    } else {
      try {

        DB::connection('pgsql_presidencia')->beginTransaction();



        if ($request->id == '0') {

          $cql = new Producto();
          $cql->fecha_inserta = date('Y-m-d H:i:s');
          $cql->usuario_inserta = Auth::user()->name;
          $cql->usuario_id_inserta = Auth::user()->identificacion;
        } else {
          $cql = Producto::find($request->id);
          $producto_ = $cql->producto;

          $cql->fecha_modifica = date('Y-m-d H:i:s');
          $cql->usuario_modifica = Auth::user()->name;
          $cambios = $objSelectRepositorio->verificarCambios($request, $cql);
        }
        $cql->producto = $producto;
        $cql->fill($request->except('producto'))->save();
        // $cql->fill($request->all())->save();

        /* $cqlTransaccion = Transaccion::where('producto_id', $request->id)->get();


        if ($request->id != '0' && !is_null($cqlTransaccion)) {

          $cqlCompra = Compra::where('producto', $producto_)->get();
          $cqlSalida = Salida::where('producto', $producto_)->get();

          if (!is_null($cqlCompra)) {
            foreach ($cqlCompra as  $value) {
              $value->producto = $request->producto;
              $value->save();
            }
          }

          if (!is_null($cqlSalida)) {
            foreach ($cqlSalida as  $value) {
              $value->producto = $request->producto;
              $value->save();
            }
          }
          foreach ($cqlTransaccion as  $value) {
            if ($value->tipo_transaccion == 'INICIAL') {
              $value->descripcion = 'INICIO DE ' . $request->producto;
              $value->save();
            }
            if ($value->tipo_transaccion == 'COMPRA') {
              $value->descripcion = 'COMPRA DE ' . $request->producto;
              $value->save();
            }
            if ($value->tipo_transaccion == 'SALIDA') {
              $value->descripcion = 'SALIDA DE ' . $request->producto;
              $value->save();
            }
            if ($value->tipo_transaccion == 'DEVOLUCION') {
              $value->descripcion = 'DEVOLUCION DE ' . $request->producto;
              $value->save();
            }
          }
        } */

        if ($request->id == '0') {
          $cqlTransaccion = new Transaccion();
          $cqlTransaccion->descripcion = 'INICIO DE ' . $cql->producto;
          $cqlTransaccion->producto_id = $cql->id;
          $cqlTransaccion->fecha_inserta = date('Y-m-d H:i:s');
          $cqlTransaccion->usuario_inserta =  Auth::user()->name;
          $cqlTransaccion->cantidad =  0;
          $cqlTransaccion->stock_disponible =  0;
          $cqlTransaccion->tipo_transaccion =  'INICIAL';
          $cqlTransaccion->ultima_transaccion =  true;
          $cqlTransaccion->save();
        }

        if ($cambios != [] && $request->id != '0')   $objSelectRepositorio->guardarLogs($cambios, $cql->id, 'decretos');

        DB::connection('pgsql_presidencia')->commit();
        $array_response['status'] = 200;
        $array_response['message'] = "Grabado Exitoso";
        $array_response['id'] = $cql->id;
      } catch (\Exception $e) {
        DB::connection('pgsql_presidencia')->rollBack();
        $array_response['status'] = 404;
        $array_response['message'] = $e->getMessage();
      }
    }
    return response()->json($array_response, 200);
  }

  public function editarProducto(request $request)
  {
    $array_response['status'] = 200;
    $array_response['datos'] = NecesidadDetalle::find($request->id);
    return response()->json($array_response, 200);
  }

  public function agregarProducto(request $request)
  {
//    dd($request);
    try {
      DB::connection('pgsql_presidencia')->beginTransaction();
      if ($request->id == 0) {
        $grabar = new NecesidadDetalle();
        $grabar->usuario_inserta = Auth::user()->name;
        $grabar->fecha_inserta = date('Y-m-d');
        $grabar->usuario_id_inserta = Auth::user()->identificacion;
      } else {
        $grabar = NecesidadDetalle::find($request->id);
        $grabar->usuario_modifica = Auth::user()->name;
        $grabar->fecha_modifica = date('Y-m-d');
      }
      $grabar->save();
      $grabar->fill($request->all())->save();

      $array_response['status'] = 200;
      $array_response['message'] = 'Grabado exitosamente';
      DB::connection('pgsql_presidencia')->commit();
    } catch (\Exception $e) {
      DB::connection('pgsql_presidencia')->rollBack();
      $array_response['status'] = 404;
      $array_response['message'] = $e->getMessage();
    }
    return response()->json($array_response, 200);
  }

}
