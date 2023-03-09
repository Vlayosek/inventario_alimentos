<?php

namespace App\Http\Controllers\InventarioAlimentos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\InventarioAlimentos\Producto;
use App\Core\Entities\InventarioAlimentos\Compra;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Ajax\SelectController;
use App\Core\Entities\Admin\tb_parametro as Param;
use App\Core\Entities\InventarioAlimentos\Devolucion;
use App\Core\Entities\InventarioAlimentos\Transaccion;
use App\Core\Entities\InventarioAlimentos\Salida;
use DB;
use Auth;

class SalidaController extends Controller
{

  public function salidas()
  {
    $datos = new SelectController();
    $medidas  = $datos->getParametro('MEDIDAS_INVENTARIO', 'http', 4);
    $tipos  = $datos->getParametro('TIPOS_INVENTARIO', 'http', 4);
    $productos  = Producto::where('eliminado', false)->pluck('producto', 'producto')->toArray();

    // dd($productos);
    return view('modules.inventario_alimentos.salidas.index', compact(
      'medidas',
      'tipos',
      'productos'
    ));
  }


  public function datatableSalidasPOSTServerSide(Request $request)
  {
    $data = Salida::select(
      'salidas.id',
      'salidas.producto',
      'salidas.fecha_salida',
      'salidas.cantidad',
      'salidas.medida',
      'salidas.tipo',
    )
      ->where('salidas.estado', 'ACT');
    return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('reg_', function ($row) {
        return 'REG-' . $row->id;
      })
      ->addColumn('', function ($row) {
        return 'Sin Acciones';
        $btn = '<table>';
        /*  $btn .= '    <tr>';
        $btn .= '        <td style="padding:2px">';
        $btn .= '            <button title="Editar" class="btn btn-primary  btn-xs btn-block"';
        $btn .= '                data-toggle="modal" data-target="#modal-REGISTRO-SALIDA"';
        $btn .= '                onclick="app.editarSalida(\'' . $row->id . '\')"';
        $btn .= '                data-backdrop="static" data-keyboard="false"><i';
        $btn .= '                    class="fa fa-edit"></i>&nbsp;Detalle</button>';
        $btn .= '        </td>';
        $btn .= '    </tr>';*/
        /* $btn .= '    <tr>';
        $btn .= '            <td style="padding:2px"> <button title="Eliminar" ';
        $btn .= '                    class="btn btn-danger  btn-xs btn-block"';
        $btn .= '                    onclick="app.eliminarVenta(\'' . $row->id . '\')"><i';
        $btn .= '                        class="fa fa-times"></i>&nbsp;Eliminar</button></td>';
        $btn .= '    </tr>'; */
        $btn .= '</table>';
        return $btn;
      })

      ->rawColumns(['', 'reg_'])
      ->toJson();
  }

  protected function consultaCompra($descripcion)
  {
    $cql = Producto::select('id')->where('descripcion', $descripcion)->where('estado', 'ACT')->where('eliminado', false)->first();
    return !is_null($cql);
  }

  public function guardarSalida(Request $request)
  {
    // dd($request->all());
    $producto = $request->producto;
    $objSelectRepositorio = new RepositorioController();
    $objSelect = new SelectController();
    $cambios = [];

    try {

      DB::connection('pgsql_presidencia')->beginTransaction();

      $cqlProducto = Producto::select('id')->where('producto', $producto)->first();
      $total_stock = (new RepositorioController())->consultaStock($cqlProducto->id);
      if ($total_stock['stock'] == 0) throw new \Exception("NO DISPONE DE STOCK DISPONIBLE");
      if ($request->cantidad > $total_stock['stock'])  throw new \Exception("NO DISPONE DE STOCK SUFICIENTE PARA REALIZAR LA SALIDA");
      $stock = $total_stock['stock'] - $request->cantidad;

      if ($request->id == '0') {
        $cql = new Salida();
        $cql->fecha_salida = date('Y-m-d');
        $cql->fecha_inserta = date('Y-m-d H:i:s');
        $cql->usuario_inserta = Auth::user()->name;
        $cql->usuario_id_inserta = Auth::user()->identificacion;
      } else {
        $cql = Salida::find($request->id);
        $cql->fecha_modifica = date('Y-m-d H:i:s');
        $cql->usuario_modifica = Auth::user()->name;
        $cambios = $objSelectRepositorio->verificarCambios($request, $cql);
      }
      $cql->fill($request->all())->save();
      // $cql->save();

      if ($cambios != [] && $request->id != '0')   $objSelectRepositorio->guardarLogs($cambios, $cql->id, 'salidas');
      if ($request->id == '0') (new RepositorioController())->nuevaTransaccion($producto, $request->cantidad, $stock, 'SALIDA');

      DB::connection('pgsql_presidencia')->commit();
      $array_response['status'] = 200;
      $array_response['message'] = "Grabado Exitoso";
      $array_response['id'] = $cql->id;
      $array_response['archivo'] = $cql->archivo_descripcion;
    } catch (\Exception $e) {
      DB::connection('pgsql_presidencia')->rollBack();
      $array_response['status'] = 404;
      $array_response['message'] = $e->getMessage();
    }

    return response()->json($array_response, 200);
  }

  public function consultaComboProducto(Request $request)
  {
    $array_response['productos'] = Producto::orderby('nombre', 'asc')->where('estado', 'ACT')->where('eliminado', false)->pluck('producto', 'producto');;
    $array_response['status'] = 200;
    return response()->json($array_response, 200);
  }

  public function eliminarVenta(Request $request)
  {

    try {
      DB::connection('pgsql_presidencia')->beginTransaction();

      $cql = Salida::find($request->id);
      $cql->fecha_modifica = date('Y-m-d H:i:s');
      $cql->usuario_modifica = Auth::user()->name;
      $cql->observacion_eliminacion = $request->observacion;
      $cql->estado = 'INA';
      $cql->eliminado = true;
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

  public function editarSalida(request $request)
  {
    $array_response['status'] = 200;
    $array_response['datos'] = Salida::find($request->id);
    return response()->json($array_response, 200);
  }
}
