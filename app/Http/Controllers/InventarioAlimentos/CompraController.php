<?php

namespace App\Http\Controllers\InventarioAlimentos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\InventarioAlimentos\Producto;
use App\Core\Entities\InventarioAlimentos\Compra;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Ajax\SelectController;
use App\Core\Entities\Admin\tb_parametro as Param;
use App\Core\Entities\InventarioAlimentos\Transaccion;
use DB;
use Auth;

class CompraController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {
    $productos  = Producto::where('eliminado', false)->pluck('producto', 'producto')->toArray();
    return view('modules.inventario_alimentos.compras.index', compact(
      'productos'
    ));
  }

  public function datatableComprasPOSTServerSide(Request $request)
  {
    $data = Compra::select(
      'compras.id',
      'compras.producto',
      'compras.fecha_caducidad',
      'compras.cantidad',
      'compras.medida',
      'compras.tipo',
      'compras.valor_compra'
    )
      ->where('compras.estado', 'ACT')->orderby('compras.fecha_inserta', 'desc');
    return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('reg_', function ($row) {
        return 'PROD-' . $row->id;
      })
      ->addColumn('', function ($row) {
        return 'Sin Acciones';

        $btn = '<table>';
        /*         $btn .= '    <tr>';
        $btn .= '        <td style="padding:2px">';
        $btn .= '            <button title="Editar" class="btn btn-primary  btn-xs btn-block"';
        $btn .= '                data-toggle="modal" data-target="#modal-REGISTRO-COMPRA"';
        $btn .= '                onclick="app.editarCompra(\'' . $row->id . '\',\'' . $row->producto . '\')"';
        $btn .= '                data-backdrop="static" data-keyboard="false"><i';
        $btn .= '                    class="fa fa-edit"></i>&nbsp;Detalle</button>';
        $btn .= '        </td>';
        $btn .= '    </tr>'; */
        /* $btn .= '    <tr>';
        $btn .= '            <td style="padding:2px"> <button title="Eliminar" ';
        $btn .= '                    class="btn btn-danger  btn-xs btn-block"';
        $btn .= '                    onclick="app.eliminarCompra(\'' . $row->id . '\',\'' . $row->producto . '\')"><i';
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

  public function guardarCompra(Request $request)
  {
    // dd($request->all());
    $producto = $request->producto;
    $objSelectRepositorio = new RepositorioController();
    $objSelect = new SelectController();
    $cambios = [];
    $cqlProducto = Producto::select('id')->where('producto', $producto)->first();
    $total_stock = (new RepositorioController())->consultaStock($cqlProducto->id);
    $stock = $total_stock['stock'] + $request->cantidad;

    try {

      $request['valor_compra'] = (float)$request->valor_compra;
      // dd($request);
      DB::connection('pgsql_presidencia')->beginTransaction();
      if ($request->id == '0') {
        $cql = new Compra();
        $cql->fecha_inserta = date('Y-m-d H:i:s');
        $cql->usuario_inserta = Auth::user()->name;
        $cql->usuario_id_inserta = Auth::user()->identificacion;
      } else {
        $cql = Compra::find($request->id);
        $cql->fecha_modifica = date('Y-m-d H:i:s');
        $cql->usuario_modifica = Auth::user()->name;
        $cambios = $objSelectRepositorio->verificarCambios($request, $cql);
      }

      $cql->fill($request->all())->save();
      // $cql->save();

      if ($cambios != [] && $request->id != '0')   $objSelectRepositorio->guardarLogs($cambios, $cql->id, 'compras');
      if ($request->id == '0') (new RepositorioController())->nuevaTransaccion($producto, $request->cantidad, $stock, 'COMPRA');

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


  public function eliminarCompra(Request $request)
  {

    // dd($request->all());
    try {
      DB::connection('pgsql_presidencia')->beginTransaction();


      //* consulto el producto para obtener el id y luego consultar si tiene stock en la tabla de transacciones
      $cqlP = Producto::select('id')->where('producto', $request->producto)->first();
      $cql = Transaccion::where('producto_id', $cqlP->id)->where('tipo_transaccion', 'COMPRA')->where('stock_disponible', '>', 0)->first();

      //* si tiene stock no puede eliminar
      if (!is_null($cql)) throw new \Exception("NO PUEDE ELIMINAR PORQUE EL PRODUCTO CONTIENE STOCK");

      $cql = Compra::find($request->id);
      $cql->fecha_modifica = date('Y-m-d H:i:s');
      $cql->usuario_modifica = Auth::user()->name;
      $cql->observacion_eliminacion = $request->observacion;
      $cql->estado = 'INA';
      $cql->eliminado = true;
      $cql->save();

      DB::connection('pgsql_presidencia')->commit();
      $array_response['status'] = 200;
      $array_response['message'] = "Eliminado Exitoso";
      $array_response['id'] = $cql->id;
    } catch (\Exception $e) {
      DB::connection('pgsql_presidencia')->rollBack();
      $array_response['status'] = 404;
      $array_response['message'] = $e->getMessage();
    }
    return response()->json($array_response, 200);
  }

  public function editarCompra(request $request)
  {
    $array_response['status'] = 200;
    $array_response['datos'] = Compra::find($request->id);
    return response()->json($array_response, 200);
  }

  public function traerDatosProducto(Request $request)
  {
    // dd($request);
    $medida = Producto::orderby('producto', 'asc')
      ->where('producto', $request->producto)
      ->where('estado', 'ACT')
      ->where('eliminado', false)->pluck('medida');

    $tipo = Producto::orderby('producto', 'asc')
      ->where('producto', $request->producto)
      ->where('estado', 'ACT')
      ->where('eliminado', false)->pluck('tipo');

    $array_response['tipo'] = $tipo;
    $array_response['medida'] = $medida;
    $array_response['status'] = 200;
    return response()->json($array_response, 200);
  }
}
