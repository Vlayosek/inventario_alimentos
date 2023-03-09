<?php

namespace App\Http\Controllers\Admin;


use App\Core\Entities\Admin\tablaBase;
use App\Core\Entities\Solicitudes\SessionAudita;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\User;
use App\Core\Entities\Solicitudes\Lineas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ajax\SelectController;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Utils;
use Yajra\Datatables\Datatables;
use Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;

class AdministradorBaseController extends Controller
{
    public function AdminBaseIndex()
    {
        $objSelect = new SelectController();
        $father = $objSelect->getfatherparameter();
        $estado = ['A' => 'ACTIVO', 'I' => 'INACTIVO'];
        return view('admin/adminBase/adminBaseIndex')->with(['estado' => $estado, 'father' => $father]);
    }

    public function AdminBaseStore(request $request)
    {

        foreach ($request->ARCHIVOS as $archivo) {
            $contents = File::get($archivo);
            dd($contents);
            $datos = explode("\t", $archivo);
            dd($datos);
            $clave = trim($datos[0]);
            $producto = trim($datos[1]);
            $precio = trim($datos[2]);

        }

        $model_name = 'Company';
        $name = 'tmp' . uniqid();
        //or you can pass the model name if you wanna create tables like company1,company2
        // Artisan::call('make:model',['name'=>$model_name]);
        //this will create a table in your DB with the provided name in this case companies
        Schema::create($name, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $tabla_id = 1;
        $table_descripcion = 'prueba';

        try {
            $request->cabecerac;

            if ($request->cabecerac == 0) {
                $objtabla = new tablaBase();
                $objtabla->tabla_id = $tabla_id;
                $objtabla->descripcion = $table_descripcion;
                $objtabla->save();
            }
            $this->key = 200;
            $this->value = "GUARDADO EXITOSO";


        } catch (\Exception $ex) {
            $this->key = 300;
            $this->value = $ex->getMessage();
        }
        return response()->json($this->value, $this->key);
    }

    public function indexLiberacionAsesor()
    {
        $name = 'AsesorCC';
        $objRole = DB::connection('pgsql')->table('roles')->where(['name' => $name])->first();
        $objSelect = new SelectController();
        $objgestores = $objSelect->getGestores($objRole->id);
        $objgestores['TODOS']='TODOS';
        return view('admin/adminBase/adminLiberacionIndex',compact(['objgestores']));
    }

    public function getDatatableLiberacionAsesor($identificacion)
    {
		
        //combo de asesores y busqueda
        $datatable1 = DB::connection('mysql_solicitudes')
            ->table('sessionaudita as sa')

            ->join('empleados as emp', 'sa.usuario_ing', 'emp.identificacion')
            ->join('nextcore.users as u','u.empleado_id','emp.identificacion');
            if($identificacion!='TODOS')
            {
                $datatable1=$datatable1->where('emp.identificacion', $identificacion);

            }

        $datatable1=$datatable1->where('sa.estado', 'A');
        $datatable1 = $datatable1->orderby('sa.created_at', 'desc')
            ->groupby(
                'sa.id',
                'sa.tipo',
                'emp.apellidos',
                'emp.nombres',
                'sa.created_at',
                'sa.estado',
				'u.empleado_id'
            )
            ->select(
                'sa.id as id',
                'sa.tipo as Tipo',
                DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as Usuario"),
                'sa.created_at as Fecha',
                'sa.estado as estado',
				'u.empleado_id as identificacion'
            )->get();


        return DataTables::of($datatable1)
            ->addColumn('opciones', function ($select) {
				
						$identificacion=$select->identificacion;
					
                return '<a id="liberado" onclick="activaAsesor(\'' . $select->id . '\',\'' . $identificacion . '\')"><span class="label label-warning">Liberar</span></a>';

            })
            ->make(true);

    }

    public function activarAsesor(request $request)
    {
		
        $usuario_ing = Auth::user()->empleado_id;
        $today = new \DateTime("now");
        $tipo='DESBLOQUEADO';
        DB::beginTransaction();
        try {

            $resultA = DB::connection('mysql_solicitudes')->table('sessionaudita')->where('id', $request->id)
                ->update(['usuario_libera' => $usuario_ing, 'updated_at' => $today, 'estado' => 'I','tipo'=>$tipo]);
			

            $resultUser = User::where('empleado_id', $request->identificacion)->update(['estado' => 'A']);
            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] = "Grabado Exitosamente";

        } catch (\Exception $e) {
            DB::rollback();
            $array_response['status'] = 404;
            $array_response['message'] = "Error al Grabar";
        }

        return response()->json($array_response, 200);
    }
    public function datatableLinea($tipo,$dato,$celular)
    {
        
        $user = Auth::user();

        $datatable1 = Lineas::with(['bp' => function ($query) {
            $query->with(['fatherpara' => function ($query) {
                $query->with(['fatherpara' => function ($query) {
                
                }]);
            }]);
        }]);
        if($celular!=0)
        {
            $datatable1= $datatable1->where(['solicitud_id'=>$dato,'celular'=>$celular])->get();

        }else{
            $datatable1= $datatable1->where(['solicitud_id'=>$dato])->get();

        }
        
            return DataTables::of($datatable1)->editColumn('celular',function($select){
                
                $p1='<p style="font-size:12px"><strong>Obsequio 1:</strong>';
                $pf1='</p>';
                $p2='<p style="font-size:12px"><strong>Obsequio 2:</strong>';
                $pf2='</p>';
                $p='<p style="font-size:12px"><strong>Obsequio:</strong> 2 ';
                $pf='</p>';
                $obsequio1=$select->obsequio1;
                $obsequio2=$select->obsequio2;

                $obsequio='';
                if($select->obsequio1==$select->obsequio2)
                {
                    $obsequio1 = str_replace("_"," ",$select->obsequio1);
                    $obsequio.=$p.$obsequio1.$pf;
                }else{
                    if($select->obsequio1=="0")
                    {
                        $obsequio1 = str_replace("0"," ",$select->obsequio1);
                        $p1='';
                        $pf1='';
                    }else{
                        $obsequio1 = str_replace("_"," ",$select->obsequio1);

                    }
                    if($select->obsequio2=="0")
                    {
                        $obsequio2 = str_replace("0"," ",$select->obsequio2);
                        $p2='';
                        $pf2='';
                    }else{
                        $obsequio2 = str_replace("_"," ",$select->obsequio2);
                    }

                    $obsequio.=$p1.$obsequio1.$pf1;
                    $obsequio.=$p2.$obsequio2.$pf2;
                }
                

                if($select->celular!=0 && $select->celular!=null && $select->celular!='')
                {
                    
                     $detalle='&nbsp;<span class="label label-info" style="font-size:12px">'.'0'.$select->celular.'</span>&nbsp;
                       <span class="label label-default"style="font-size:12px">'.$select->operadora.'</span>';

                            return $detalle.'<hr/>'.$obsequio;
                }
                return '<span class="label label-info" style="font-size:13px">No hay número definido</span>'.'<hr/>'.$obsequio;

            })

            ->addColumn('Tipo_Solicitud',function($select){
                $admin='';
                $detalle='';
                if($select->tipo_solicitud=="Transferencia_Beneficiario")
                {
                    $color='#001dff';
                    $admin='href="#" rel="popover" data-trigger="focus" data-popover-content="#list-popover'.$select->celular.'"';
                }
                     $tipo_solicitud = str_replace("_"," ",$select->tipo_solicitud);
                     $detalle.='
                       <a '.$admin.'>';
                       if($select->tipo_solicitud=="Transferencia_Beneficiario")
                        {
                        $detalle.='<span class="label" style="color:#001dff;font-size:13px">'.$tipo_solicitud.'</span>';
                        }else
                        {
                            $detalle.='<span class="label" style="color:#101010;font-size:13px">'.$tipo_solicitud.'</span>';

                        }
                      $detalle.='</a>
                       </p>
                       
                      <div id="list-popover'.$select->celular.'" class="hide tablacorta">
                            <div class="col-lg-12">
                                <div class="col-md-6"><strong>Cedula/Donante</strong></div>
                                <div class="col-md-6"><strong>Nombre/Donante</strong></div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-md-6">'.$select->cedula_donante.'</div>
                                <div class="col-md-6">'.$select->nombre_donante.'</div>
                            </div>
                            <div class="col-lg-12">
                                 <hr/>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-md-6"><strong>Celular/Donante</strong></div>
                                <div class="col-md-6"><strong>N/Cuenta</strong></div>
                            </div>
                            <div class="col-lg-12">
                                 <div class="col-md-6">'.$select->celular_donante.'</div>
                                 <div class="col-md-6">'.$select->n_cuenta_donante.'</div>
                            </div>
                            <div class="col-lg-12">
                              <hr/>
                             </div>
                            <div class="col-lg-12">
                                <div class="col-md-6"><strong>Cedula/RL</strong></div>
                                <div class="col-md-6"><strong>Nombre/RL</strong></div>

                            </div>
                            <div class="col-lg-12">
                                <div class="col-md-6">'.$select->cedula_RL.'</div>
                                <div class="col-md-6">'.$select->nombre_RL.'</div>
                            </div>
                            <div class="col-lg-12">
                               <hr/>
                             </div>
                            <div class="col-lg-12">
                            <div class="col-md-6"><strong>Cargo/RL</strong></div>
                            <div class="col-md-6"><strong>Direccion/Donante</strong></div>

                        </div>
                        <div class="col-lg-12">
                            <div class="col-md-6">'.$select->cargo_RL.'</div>
                            <div class="col-md-6">'.$select->direccion_donante.'</div>
                        </div>
                      </div>';

                      

                            return $detalle;

            })
            ->addColumn('DetalleBp',function($select){

                    $detalle='<table class="tablacorta">
                    <tr>
                    <td><strong>Bp:</strong></td>
                    <td>'.$select->bp->descripcion.'</td>
                    </tr>
                    <tr>
                    <td><strong>Plan:</strong></td>
                    <td>'.$select->bp->fatherpara->descripcion.'</td>
                    </tr>
                    <tr>
                    <td><strong>Tarifa Básica:</strong></td>
                    <td>'.$select->bp->fatherpara->fatherpara->descripcion.'</td>
                    </tr>';
                    
                    $detalle=$detalle.'<tr>
                    <td><strong>Cuota:</strong></td>
                    <td>'.$select->cuota.'</td>
                    </tr>';
                    
                    $detalle=$detalle.'</table>';

                    return $detalle;
            })
            ->addColumn('Equipo',function($select){

                $detalle='<span class="label label-danger">Sin Equipo</span>';

                if(!$select->equipo)
                {
                    $detalle='<table class="tablacorta">
                    <tr>
                    <td><strong>Equipo:</strong></td>
                    <td><input type="checkbox" checked disabled></td>
                    </tr>
                    <tr>
                    <td><strong>Marca:</strong></td>
                    <td>'.$select->marca.'</td>
                    </tr>
                    <tr>
                    <td><strong>Modelo:</strong></td>
                    <td>'.$select->modelo.'</td>
                    </tr></table>';
                }
                

                    return $detalle;
            })->rawColumns(['celular','Tipo_Solicitud'])
                ->make(true);
     
    }
              
}
