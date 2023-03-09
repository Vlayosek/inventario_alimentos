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

class ProductoController extends Controller
{

  public function cocinaProducto()
  {
    $datos = new SelectController();
    $medidas  = $datos->getParametro('MEDIDAS_INVENTARIO', 'http', 4);
    $tipos  = $datos->getParametro('TIPOS_INVENTARIO', 'http', 4);

    return view('modules.inventario_alimentos.cocina.producto.index', compact(
      'medidas',
      'tipos'
    ));
  }

  public function necesidades()
  {
    $datos = new SelectController();
    $medidas  = $datos->getParametro('MEDIDAS_INVENTARIO', 'http', 4);
    $tipos  = $datos->getParametro('TIPOS_INVENTARIO', 'http', 4);

    return view('modules.inventario_alimentos.cocina.necesidad.index', compact(
      'medidas',
      'tipos'
    ));
  }

  public function datatableNecesidadesPOSTServerSide($fecha_inicio, $fecha_fin, $tipoActual)
  {
    $objRepo = new Rp();
    $data = Necesidad::select(
      'necesidad.id',
      'necesidad.fecha_solicitud',
      'necesidad.aceptada',
      'productos.medida',
      'productos.descripcion',
      'productos.fecha_inserta'
    )
      ->join('sc_inventario_alimentos.necesidades_detalles','necesidades_detalles.necesidad_id','necesidad,id')

      ->where('productos.estado', 'ACT')
      ->where('productos.eliminado', false)
      ->orderby('productos.fecha_inserta', 'desc')
      ->distinct();
    return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('reg_', function ($row) {
        return 'PROD-' . $row->id;
      })
      ->addColumn('stock', function ($row) {
        return $row->compras_ + $row->devoluciones_ - $row->ventas_;
      })
      ->addColumn('salida_total', function ($row) {
        return $row->ventas_ - $row->devoluciones_;
      })
      ->addColumn('ventas', function ($row) {
        return $row->ventas_;
      })
      ->addColumn('devoluciones', function ($row) {
        return $row->devoluciones_;
      })
      ->addColumn('compras', function ($row) {
        return $row->compras_;
      })

      ->addColumn('', function ($row) {
        return 'Sin Acciones';
        $btn = '<table>';
        /*         $btn .= '    <tr>';
        $btn .= '        <td style="padding:2px">';
        $btn .= '            <button title="Editar" class="btn btn-primary  btn-xs btn-block"';
        $btn .= '                data-toggle="modal" data-target="#modal-REGISTRO-PRODUCTO"';
        $btn .= '                onclick="app.editarProducto(\'' . $row->id . '\')"';
        $btn .= '                data-backdrop="static" data-keyboard="false"><i';
        $btn .= '                    class="fa fa-edit"></i>&nbsp;Detalle</button>';
        $btn .= '        </td>';
        $btn .= '    </tr>'; */
        /* $btn .= '    <tr>';
        $btn .= '            <td style="padding:2px"> <button title="Eliminar" ';
        $btn .= '                    class="btn btn-danger  btn-xs btn-block"';
        $btn .= '                    onclick="app.eliminarProducto(\'' . $row->id . '\')"><i';
        $btn .= '                        class="fa fa-times"></i>&nbsp;Eliminar</button></td>';
        $btn .= '    </tr>'; */
        $btn .= '</table>';
        return $btn;
      })

      ->rawColumns(['', 'reg_', 'stock', 'compras', 'ventas', 'devoluciones', 'salida_total'])
      ->toJson();
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
    $array_response['datos'] = Producto::find($request->id);
    return response()->json($array_response, 200);
  }
}
