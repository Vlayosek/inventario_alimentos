<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use App\role_has_permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ajax\SelectController;
use Illuminate\Support\Facades\Auth;
use nextcore\Core\Repositories\AdminRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Utils;
use Yajra\Datatables\Datatables;
use App\Core\Entities\Admin\Empresa;


class EmpresaController extends Controller
{

    public function index()
    {
        return view('admin.empresas.index');
    }

    public function getDatatable(){
        $consulta=Empresa::all();
               
        $array_response['status'] = 200;
        $array_response['datos'] = $consulta;
             
      return response()->json($array_response, 200);
    }
    public function saveEmpresa(request $request)
    {
        if($request->tipo=='actualiza'){

            $consulta=Empresa::Find($request->id);
            $consulta->usuario_ing=Auth::user()->id;
        }
        else{

            $consulta=new Empresa();
            $consulta->usuario_mod=Auth::user()->id;

        }

        $consulta->descripcion=$request->descripcion;
        $consulta->nombres=$request->nombres;
        $consulta->direccion=$request->direccion;
        $consulta->provincia_id=$request->provincia_id;
        $consulta->ciudad_id=$request->ciudad_id;
        $consulta->telefono=$request->convencional;
        $consulta->estado='A';
        $consulta->save();
        $array_response['status'] = 200;
        $array_response['message'] = 'GRABADO EXITOSAMENTE';
             
      return response()->json($array_response, 200);
    }
    public function EliminarEmpresa(request $request){
        $consulta=Empresa::Find($request->id);
        if($consulta->estado!='A')
        $consulta->estado='A';
        else
        $consulta->estado='I';

        $consulta->save();
        $array_response['status'] = 200;
        $array_response['message'] = 'ELIMINADO EXITOSAMENTE';
        return response()->json($array_response, 200);

    }

    



}
