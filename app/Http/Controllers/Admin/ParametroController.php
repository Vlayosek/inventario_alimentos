<?php

namespace App\Http\Controllers\Admin;

use App\Core\Entities\Admin\parametro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ajax\SelectController;
use DB;
use Auth;
use Illuminate\Support\Facades\Utils;
use Yajra\Datatables\Datatables;

class ParametroController extends Controller
{
    public function index()
    {
        $objSelect = new SelectController();
        $father = $objSelect->getfatherparameter();
        $estado = ['A' => 'ACTIVO', 'I' => 'INACTIVO'];
        //  $verificacion=  ['0'=>'NINGUNA','NORMA'=>'NORMA','CRITERIO'=>'CRITERIO','SUBCRITERIO'=>'SUBCRITERIO','METRICA'=>'METRICA'];
        return view('admin.parametros.index', compact(['estado', 'father']));
    }
    public function getParameterFather($parameter)
    {
        $objSelect = new SelectController();
        return $objSelect->getParameterFathera($parameter, 'json');
    }
    public function SaveParameter(request $request)
    {
        $data = parametro::where('nivel', 1)->first();
        if ($request->father == $data->id) {
            $request->father == null;
        }

        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'Escriba el nombre del parametro',
        ];
        $this->validate($request, $rules, $messages);
        $array_response = [];
        try {
            //Grabar dato

            if ($request->var != 0) {
                $oobjOption         = parametro::Find($request->var);
            } else {
                $oobjOption         = new parametro();
            }

            if ($request->father != null) {
                $oobjOption->parametro_id = $request->father;
                $result = parametro::Find($request->father);
                $oobjOption->nivel       = $result->nivel + 1;
            } else {
                $oobjOption->nivel       = 2;
            }
            if ($request->optionid != null) {
                $oobjOption->estado  = $request->optionid;
            } else {
                $oobjOption->estado = 'A';
            }
            $oobjOption->descripcion  = $request->name;

            $intCod = parametro::where('descripcion', $request->name)->first();

            if (!is_null($intCod) && $oobjOption->descripcion != $request->name) {
                throw new \Exception("Ya se encuentra el parametro registrado");
            } else {
                $oobjOption->descripcion  = $request->name;
                $oobjOption->verificacion = 1;
                // $oobjOption->empresa_id=Auth::user()->empresa_id;
                $oobjOption->save();
                $array_response['status'] = 200;
                $array_response['message'] = 'Se ha Guardado Exitosamente ';
            }
        } catch (\Exception $e) {
            $array_response['status'] = 404;
            $array_response['message'] = 'Error al guardar los datos , consulte con el Administrador:' . $e->getMessage();
        }

        return response()->json($array_response, 200);
    }
    public function ParameterEliminar(request $request)
    {
        $result = parametro::where(['parametro_id' => $request->id])->get();


        try {
            if (count($result) > 0) {
                throw new \Exception("No puede Eliminar,Parametro se encuentra relacionado con otro ");
            }
            $objEliminar = parametro::find($request->id);
            $objEliminar->delete();
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Eliminado Exitosamente ';
        } catch (\Exception $e) {
            $array_response['status'] = 404;
            $array_response['message'] = 'Error al Eliminar los datos porfavor consulte con el Administrador' . $e->getMessage();
        }

        return response()->json($array_response, 200);
    }
    public function getDatatable()
    {

        return DataTables::of(
            DB::connection('pgsql')
                ->table('parametro AS g')
                ->leftjoin('parametro AS e', 'e.id', 'g.parametro_id')
                ->select('g.id as id', 'g.descripcion AS name', 'e.descripcion AS padre', 'g.estado as estado', 'g.parametro_id as parameter', 'g.verificacion as verificacion')
                ->get()

        )->addColumn('estado', function ($select) {
            switch ($select->estado) {
                case 'A':
                    // return '<a onclick="PedirConfirmacion(\'' . $select->id . '\',\'' . $select->parameter . '\',\'' . 'estado' . '\')" class="btn btn-xs btn-primary">Activo</a>';
                    return '<span class="badge bg-info">ACTIVO</span>';

                case 'I':
                    //  return '<a onclick="PedirConfirmacion(\'' . $select->id . '\',\'' . $select->parameter . '\',\'' . 'estado' . '\')" class="btn btn-xs btn-danger">Inactivo</a>';
                    return '<span class="badge bg-danger">INACTIVO</span>';

                default:
                    //  return '<a onclick="PedirConfirmacion(\'' . $select->id . '\',\'' . $select->parameter . '\',\'' . 'estado' . '\')" class="btn btn-xs btn-success">Desconocido</a>';
                    return '<span class="badge bg-success">DESCONOCIDO</span>';
            }
        })
            ->addColumn('actions', function ($select) {

                return '<a href="#" onclick="EditChanges(\'' . $select->id . '\',\'' . $select->name . '\',\'' . $select->estado . '\',\'' . $select->parameter . '\',\'' . $select->verificacion . '\')"
                        data-target="#modal-parametro" data-toggle="modal"
                        class="btn btn-primary btn-xs">
                        <i class="fa fa-edit"></i>&nbsp;Editar</a>

                        <a href="#" onclick="PedirConfirmacion(\'' . $select->id . '\',\'' . $select->parameter . '\',\'' . 'delete' . '\')"
                        class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>&nbsp;Eliminar</a>';
            })

            ->make(true);
    }
}
