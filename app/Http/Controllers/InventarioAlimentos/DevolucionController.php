<?php

namespace App\Http\Controllers\InventarioAlimentos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\InventarioAlimentos\Producto;
use App\Core\Entities\InventarioAlimentos\Compra;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Ajax\SelectController;
use App\Core\Entities\InventarioAlimentos\Devolucion;
use App\Core\Entities\InventarioAlimentos\Transaccion;
use DB;
use Auth;

class DevolucionController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function devoluciones()
  {
    $datos = new SelectController();
    $medidas  = $datos->getParametro('MEDIDAS_INVENTARIO', 'http', 4);
    $tipos  = $datos->getParametro('TIPOS_INVENTARIO', 'http', 4);
    $productos  = Producto::where('eliminado', false)->pluck('producto', 'producto')->toArray();

    // dd($productos);
    return view('modules.inventario_alimentos.devoluciones.index', compact(
      'medidas',
      'tipos',
      'productos'
    ));
  }

  public function datatableDevolucionesPOSTServerSide(Request $request)
  {
    $data = Devolucion::select(
      'devoluciones.id',
      'devoluciones.producto',
      'devoluciones.fecha_devolucion',
      'devoluciones.medida',
      'devoluciones.cantidad',
    )
      ->where('devoluciones.estado', 'ACT');
    return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('reg_', function ($row) {
        return 'PROD-' . $row->id;
      })
      ->addColumn('', function ($row) {
        return 'Sin Acciones';

        $btn = '<table>';
        /*   $btn .= '    <tr>';
        $btn .= '        <td style="padding:2px">';
        $btn .= '            <button title="Editar" class="btn btn-primary  btn-xs btn-block"';
        $btn .= '                data-toggle="modal" data-target="#modal-REGISTRO-DEVOLUCION"';
        $btn .= '                onclick="app.editarDevolucion(\'' . $row->id . '\')"';
        $btn .= '                data-backdrop="static" data-keyboard="false"><i';
        $btn .= '                    class="fa fa-edit"></i>&nbsp;Detalle</button>';
        $btn .= '        </td>';
        $btn .= '    </tr>'; */
        /* $btn .= '    <tr>';
        $btn .= '            <td style="padding:2px"> <button title="Eliminar" ';
        $btn .= '                    class="btn btn-danger  btn-xs btn-block"';
        $btn .= '                    onclick="app.eliminarDevolucion(\'' . $row->id . '\')"><i';
        $btn .= '                        class="fa fa-times"></i>&nbsp;Eliminar</button></td>';
        $btn .= '    </tr>'; */
        $btn .= '</table>';
        return $btn;
      })

      ->rawColumns(['', 'reg_'])
      ->toJson();
  }

  public function guardarDevolucion(Request $request)
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
      $cantidad = (int)$request->cantidad;
      if ($cantidad > $total_stock['stock_salida'])   throw new \Exception("EL STOCK ES SUPERIOR A LA CANTIDAD DE SALIDA DEL PRODUCTO");
      $stock = $total_stock['stock'] + $request->cantidad;

      if ($request->id == '0') {
        $cql = new Devolucion();
        $cql->fecha_devolucion = date('Y-m-d');
        $cql->fecha_inserta = date('Y-m-d H:i:s');
        $cql->usuario_inserta = Auth::user()->name;
        $cql->usuario_id_inserta = Auth::user()->identificacion;
      } else {
        $cql = Devolucion::find($request->id);
        $cql->fecha_modifica = date('Y-m-d H:i:s');
        $cql->usuario_modifica = Auth::user()->name;
        $cambios = $objSelectRepositorio->verificarCambios($request, $cql);
      }
      $cql->fill($request->all())->save();

      if ($cambios != [] && $request->id != '0')   $objSelectRepositorio->guardarLogs($cambios, $cql->id, 'devoluciones');
      if ($request->id == '0') (new RepositorioController())->nuevaTransaccion($producto, $request->cantidad, $stock, 'DEVOLUCION');

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

  public function eliminarDevolucion(Request $request)
  {

    try {
      DB::connection('pgsql_presidencia')->beginTransaction();

      $cql = Devolucion::find($request->id);
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

  public function editarDevolucion(request $request)
  {
    $array_response['status'] = 200;
    $array_response['datos'] = Devolucion::find($request->id);
    return response()->json($array_response, 200);
  }

  public function traerMedida(Request $request)
  {
    // dd($request);
    $array_response['medidas'] = Producto::orderby('producto', 'asc')->where('producto', $request->producto)->where('estado', 'ACT')->where('eliminado', false)->pluck('medida', 'id');
    $array_response['status'] = 200;
    return response()->json($array_response, 200);
  }
}
