<?php

namespace App\Http\Controllers\InventarioAlimentos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Ajax\SelectController as SC;
use App\Http\Controllers\InventarioAlimentos\RepositorioController as RP;

use App\Core\Entities\InventarioAlimentos\Producto;
use App\Core\Entities\InventarioAlimentos\Compra;
use App\Core\Entities\InventarioAlimentos\Transaccion;


class AprobarController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {
    return view('modules.inventario_alimentos.aprobar.index');
  }
  public function getDatatableGestionSolicitudesServerSide($fecha_inicio, $fecha_fin, $tipoActual)
  {
    $objRepo = new Rp();
    $data = $objRepo->selectDatatableNecesidades(false);

    switch ($tipoActual) {
      case 'PENDIENTES':
        $estado = ['PENDIENTE ACEPTAR'];
        $data = $objRepo->filtroSinFecha($data, $estado);
        break;
      case 'GESTIONADAS':
        $estado = ['ACEPTADA'];
        $data = $objRepo->filtroConFecha($data, $fecha_inicio, $fecha_fin, $estado);
        break;
    }
    //dd($data->get()->toArray());
    return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('', function ($row) use ($tipoActual) {
        $consulta = true;
        if ($tipoActual == "PENDIENTES") $consulta = false;
        $btn = ' <table style="width:100%;border:0px">';
        $btn .= '<tr><td style="padding: 2px;border:0px;text-align:center;"><button class="btn btn-default btn-block btn-xs"  onclick="app.gestionSolicitud(\'' . $row->id . '\',\'' . $consulta . '\')" data-toggle="modal" data-target="#modal-GESTION_SOLICITUD" data-backdrop="static" data-keyboard="false">&nbsp;GESTIÓN SOLICITUD</button></td></tr>';
        $btn .= ' </table>';
        return $btn;
      })
      ->rawColumns([''])
      ->make(true);
  }
  public function filtroEstadosGestion(request $request)
  {
    $objRepo = new Rp();
    $fecha_inicio = $request->fecha_inicio;
    $fecha_fin = $request->fecha_fin;

    $estado = ['PENDIENTE ACEPTAR'];
    $pendiente = $objRepo->filtroSinFecha(clone $objRepo->selectDatatableNecesidades(true), $estado);
    $estado = ['ACEPTADA'];
    $gestionados = $objRepo->filtroConFecha(clone $objRepo->selectDatatableNecesidades(true), $fecha_inicio, $fecha_fin, $estado);

    $array_response['status'] = 200;
    $array_response['pendientes'] = $pendiente->count('necesidades.id');
    $array_response['gestionados'] = $gestionados->count('necesidades.id');
    return response()->json($array_response, 200);
  }
}
