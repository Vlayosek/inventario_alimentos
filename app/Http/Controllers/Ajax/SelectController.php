<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Core\Entities\Admin\Empresa;
use App\Core\Entities\Admin\mhr;
use App\Core\Entities\Admin\roles as Role;
use App\Core\Entities\TalentoHumano\Distributivo\Persona as PersonaUath;
use App\Core\Entities\TalentoHumano\Distributivo\Historia_laboral;
use App\Core\Entities\TalentoHumano\Distributivo\Area;
use App\Core\Entities\TalentoHumano\Distributivo\Asignacion_area;
use App\Core\Entities\TalentoHumano\Distributivo\Tipo_contrato;
use App\User;
use DateTime;
use Illuminate\Support\Facades\Storage;

class SelectController extends Controller
{
    public function getEmpresas()
    {
        $consulta = Empresa::where('estado', 'A')->get();

        $array_response['status'] = "200";
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    public function getProvincias()
    {
        $consulta = DB::connection('pgsql')
            ->table('parametro_ciudad')
            ->where('verificacion', 'PROVINCIA')
            ->where('estado', 'A')
            ->get();
        $array_response['status'] = "200";
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    public function getCiudades()
    {
        $consulta = DB::connection('pgsql')
            ->table('parametro_ciudad')
            ->where('verificacion', 'CIUDAD')
            ->where('estado', 'A')
            ->get();
        $array_response['status'] = "200";
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }

    private function transform($result, $response)
    {
        if (count($result) > 0) {
            if ($response == 'json') {
                return response()->json(['data' => $result], 200);
            } else {
                return $result;
            }
        } else {
            if ($response == 'json') {
                return response()->json(['No hay registros'], 404);
            } else {
                return response()->view('errors.503', [], 503);

                //abort(401);
            }
        }
    }

    public function base64_to_imagen($base64_string, $name)
    {
        try {
            /* $rutaImagenSalida = $ruta;
            $imagenBinaria = base64_decode($base64_string);
            $bytes = file_put_contents($rutaImagenSalida, $imagenBinaria); */

            $data = substr($base64_string, strpos($base64_string, ',') + 1);
            // Se decodifica
            $data = base64_decode($data);

            Storage::disk('simed')->put($name, $data);


            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function dontBandeja($bandeja, $solicitud, $si, $verifica = 0)
    {

        $estadoVerificacion = DB::connection('mysql_solicitudes')
            ->table('bestados as be')
            ->join('nextcore.parametro as tbp', 'tbp.id', 'be.departamento_id')
            ->join('nextcore.parametro as tbp2', 'tbp2.id', 'be.estado_linea_id')
            ->join('nextcore.parametro as tbp3', 'tbp3.id', 'tbp2.parametro_id')
            ->where(['be.estado' => 'A'])
            ->where('be.solicitud_id', $solicitud)
            ->select('tbp.descripcion as descripcion', 'be.estado_linea_id as estado', 'tbp2.verificacion as verificaEstado', 'tbp3.verificacion as verificabandeja')
            ->get()->toArray();
        //   dd($estadoVerificacion);
        if ($estadoVerificacion[0]->verificaEstado > $estadoVerificacion[0]->verificabandeja && $bandeja[0] == 'BANDEJA_VALIDACION') {

            return $this->transform(0, 'http');
        } elseif ($estadoVerificacion[0]->descripcion == $bandeja[0]) {
            return $this->transform(1, 'http');
        } else {
            $objBandeja = DB::connection('pgsql')
                ->table('parametro')
                ->whereIn('descripcion', $bandeja)
                ->select('id', 'descripcion')->get()->toArray();

            $arrayBandeja = array();
            foreach ($objBandeja as $item) {
                array_push($arrayBandeja, $item->id);
            }


            if ($si) {
                $verifica = DB::connection('mysql_solicitudes')
                    ->table('bestados as a')
                    ->join('nextcore.parametro as tp', 'tp.id', 'a.estado_linea_id')
                    ->join('solicitud as s', 'n_solicitud', 'a.solicitud_id')
                    ->where(['a.estado' => 'A'])
                    ->where('s.estado', 'A')
                    ->where('tp.descripcion', 'SOLICITUD INGRESADA')
                    ->where('a.solicitud_id', $solicitud)
                    ->count();
                $var1 = 0;
                $var2 = 1;
            } else {
                $verifica = DB::connection('mysql_solicitudes')
                    ->table('bestados')
                    ->where(['estado' => 'A'])
                    ->where('solicitud_id', $solicitud)
                    ->whereIn('departamento_id', $arrayBandeja)
                    ->count();
                $var1 = 1;
                $var2 = 0;
            }

            if ($verifica > 0) {
                return $this->transform($var2, 'http');
            } else {
                return $this->transform($var1, 'http');
            }
        }
    }

    public function searchCiudad($parametro, $type = 'json')
    {
        $result = DB::connection('pgsql')
            ->table('parametro AS C')
            ->where('C.parametro_id', $parametro)
            ->where('C.estado', 'A')
            ->groupBy('C.descripcion', 'C.id')
            ->orderBy('C.descripcion', 'desc')
            ->select('C.id as id', 'C.descripcion as descripcion')->get();

        //dd($result);

        if (count($result) > 0) {
            //$result = $result->get('descripcion', 'id');
            //$lista['data'] = $result;
            $array_response['status'] = 200;
            $array_response['message'] = $result;
        } else {
            $array_response['status'] = 404;
            $array_response['message'] = "No hay resultados";
        }



        return $array_response;
    }

    public function getPermission($id, $type = 'json')
    {
        $result = DB::connection('pgsql')
            ->table('menus AS f')
            ->join('role_has_permission as h', 'h.menu_id', 'f.id')
            ->where('h.role_id', '=', $id)
            ->groupBy('f.id', 'f.name')
            ->orderBy('f.name', 'desc')
            ->select('f.id as id', 'f.name as name');
        if ($type == 'json') {
            $result = $result->get('id');
            $lista['data'] = $result;
            return response()->json($lista, 200);
        } else {
            $result = $result->pluck('id')->toArray();
            return $result;
        }
    }

    public function getParametro($parametro, $type = 'json', $v = 0)
    {


        $result1 = DB::connection('pgsql')
            ->table('parametro AS C')
            ->where('C.descripcion', $parametro)
            ->where('C.estado', 'A')
            ->select('C.id as id')->first();

        $result = DB::connection('pgsql')
            ->table('parametro AS C')
            ->where('C.parametro_id', !is_null($result1) ? $result1->id : 0)
            ->where('C.estado', 'A');

        $result = $result->groupBy('C.descripcion', 'C.id')
            ->orderBy('C.descripcion', 'desc')
            ->select('C.id as id', 'C.descripcion as descripcion');

        if ($type == 'json') {
            $result = $result->get('descripcion', 'id');
            $lista['data'] = $result;
            return response()->json($lista, 200);
        } else {
            if ($v == 4) {
                $result = $result->orderBy('id', 'asc')
                    ->pluck('descripcion', 'descripcion')->toArray();
            } else {
                if ($v == 3) {
                    $result = $result->pluck('id', 'descripcion')->toArray();
                } else {
                    $result = $result->pluck('descripcion', 'id')->toArray();
                }
            }

            return $result;
        }
    }

    public function getParameterFathera($parameter, $type = 'json')
    {
        $result = DB::connection('pgsql')
            ->table('parametro AS C')
            ->where('nivel', $parameter - 1)
            ->where('C.estado', 'A')
            ->groupBy('C.id', 'C.descripcion')
            ->orderBy('C.descripcion', 'desc')
            ->select('C.id as id', 'C.descripcion as descripcion');
        if ($type == 'json') {
            $result = $result->get('descripcion', 'id');
            $lista['data'] = $result;
            return response()->json($lista, 200);
        } else {
            $result = $result->pluck('descripcion', 'id')->toArray();
            return $result;
        }
    }

    public function getfatherparameter($response = 'http')
    {
        $result = DB::connection('pgsql')
            ->table('parametro AS F')
            ->where('F.estado', 'A')
            ->select('F.id AS id', 'F.descripcion as descripcion')
            ->orderBy('descripcion', 'desc')->pluck('descripcion', 'id')->toArray();

        return $this->transform($result, $response);
    }

    public function getGestores($role, $response = 'http')
    {
        $result = DB::connection('pgsql')
            ->table('model_has_roles as r')
            ->join('users as u', 'r.model_id', 'u.id')
            ->join('solicitudes.empleados as emp', 'u.empleado_id', 'emp.identificacion')
            ->where('r.role_id', $role)
            ->select('emp.identificacion as id', DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name"))
            ->pluck('name', 'id')->toArray();
        return $this->transform($result, $response);
    }

    public function getFather($response = 'http')
    {
        $result = DB::connection('pgsql')
            ->table('core.menus AS F')
            ->where('F.parent', '0')
            ->where('F.enabled', '1')
            ->select('F.id AS id', DB::raw('RTRIM(F.name) AS name'))
            ->orderBy('name', 'desc')->pluck('name', 'id')->toArray();

        return $this->transform($result, $response);
    }
    public function consultarUsuariosRol($tipo)
    {
        if (!is_array($tipo)) $tipo = [$tipo];

        $role = Role::select('id')->whereIn('name', $tipo)->pluck('id')->toArray();

        $model = mhr::select('model_id')
            ->whereIn('role_id', $role)
            ->pluck('model_id')
            ->toArray();


        $usuarios = User::select('nombreCompleto', 'id')
            ->whereIn('id', $model)
            ->pluck('nombreCompleto', 'id')
            ->toArray();

        return $usuarios;
    }
    public function buscarDatosUath($identificacion, $persona_id = null)
    {

        $nombres_ = '';
        if ($persona_id != null) {
            $cqlPersona = PersonaUath::find($persona_id);
            $identificacion = $cqlPersona != null ? $cqlPersona->identificacion : '';
        } else {
            $cqlPersona = PersonaUath::where('identificacion', $identificacion)->get()->first();
        }
        $nombres_ = $cqlPersona != null ? $cqlPersona->apellidos_nombres : '';

        $consultaAsignaciones = Asignacion_area::where('identificacion', $identificacion)->where('eliminado', false)->pluck('area_id')->toArray();

        $dataSubsuario = Historia_laboral::leftjoin('sc_distributivo_.personas as p', 'p.id', 'historias_laborales.persona_id')
            ->leftjoin('sc_distributivo_.areas  as a', 'a.id', 'historias_laborales.area_id')
            ->leftjoin('sc_distributivo_.cargos  as c', 'c.id', 'historias_laborales.cargo_id')
            ->leftjoin('sc_distributivo_.tipos_contratos  as tp', 'tp.id', 'historias_laborales.tipo_contrato_id')
            ->select(
                'historias_laborales.id as historia_laboral_id',
                'historias_laborales.area_id',
                'p.id as persona_id',
                'p.correo_institucional as correo_institucional',
                'c.es_jefe_inmediato as jefe',
                'a.area_id as are_id_padre',
                'a.nombre as nombre_area',
                'a.sigla as sigla',
                'p.identificacion as identificacion_',
                'c.nombre as cargo',
                'tp.nombre as tipo_contrato'
            )
            ->where('p.identificacion', $identificacion)
            ->where('sc_distributivo_.historias_laborales.eliminado', false)
            ->where('sc_distributivo_.historias_laborales.es_principal', true)
            ->where('sc_distributivo_.historias_laborales.eliminado_por_reingreso', false)
            ->where('sc_distributivo_.historias_laborales.estado', 'ACT')
            ->orderby('sc_distributivo_.historias_laborales.fecha_ingreso', 'desc')
            ->get()->first();

        $dataSubsuario2 = Historia_laboral::leftjoin('sc_distributivo_.personas as p', 'p.id', 'historias_laborales.persona_id')
            ->leftjoin('sc_distributivo_.areas  as a', 'a.id', 'historias_laborales.area_id')
            ->leftjoin('sc_distributivo_.cargos  as c', 'c.id', 'historias_laborales.cargo_id')
            ->leftjoin('sc_distributivo_.tipos_contratos  as tp', 'tp.id', 'historias_laborales.tipo_contrato_id')
            ->select(
                'historias_laborales.id as historia_laboral_id',
                'historias_laborales.area_id',
                'p.id as persona_id',
                'p.correo_institucional as correo_institucional',
                'c.es_jefe_inmediato as jefe',
                'a.area_id as are_id_padre',
                'a.nombre as nombre_area',
                'a.sigla as sigla',
                'c.nombre as cargo',
                'tp.nombre as tipo_contrato'

            )
            ->where('p.identificacion', $identificacion)
            ->where('sc_distributivo_.historias_laborales.eliminado', false)
            ->where('sc_distributivo_.historias_laborales.es_principal', false)
            ->where('sc_distributivo_.historias_laborales.eliminado_por_reingreso', false)

            ->where('sc_distributivo_.historias_laborales.estado', 'ACT')
            ->orderby('historias_laborales.fecha_ingreso', 'desc')
            ->get()->first();



        $es_jefe = $dataSubsuario != null ? $dataSubsuario->jefe : false;
        $usuario['are_id_padre'] = $dataSubsuario != null ? $dataSubsuario->are_id_padre : 0;
        $usuario['are_id_padre_2'] = $dataSubsuario2 != null ? $dataSubsuario2->are_id_padre : 0;
        $usuario['area_id'] = $dataSubsuario != null ? $dataSubsuario->area_id : 0;
        $usuario['area_id_2'] = $dataSubsuario2 != null ? $dataSubsuario2->area_id : 0;
        $usuario['historia_laboral_id_2'] = $dataSubsuario2 != null ? $dataSubsuario2->historia_laboral_id : 0;

        $datosJefes = Historia_laboral::leftjoin('sc_distributivo_.personas as p', 'p.id', 'historias_laborales.persona_id')
            ->leftjoin('sc_distributivo_.areas  as a', 'a.id', 'historias_laborales.area_id')
            ->leftjoin('sc_distributivo_.cargos  as c', 'c.id', 'historias_laborales.cargo_id')
            ->select(
                'historias_laborales.id as historia_laboral_id',
                'historias_laborales.area_id',
                'p.id as persona_id',
                'p.correo_institucional as correo_institucional',
                'historias_laborales.es_jefe_inmediato as jefe',
                'a.area_id as are_id_padre',
                'a.nombre as nombre_area',
                'p.identificacion as identificacion_',
                'p.apellidos_nombres as apellidos_nombres_',
            )
            ->where('sc_distributivo_.historias_laborales.eliminado', false);
        if ($es_jefe)
            $datosJefes = $datosJefes->where('sc_distributivo_.historias_laborales.area_id', $usuario['are_id_padre']);
        else
            $datosJefes = $datosJefes->where('sc_distributivo_.historias_laborales.area_id', $usuario['area_id']);

        $datosJefes = $datosJefes
            ->where('sc_distributivo_.historias_laborales.estado', 'ACT')
            //  ->where('sc_distributivo_.historias_laborales.es_principal',true)
            ->where('c.es_jefe_inmediato', true)
            ->where('sc_distributivo_.historias_laborales.eliminado_por_reingreso', false)
            ->orderby('historias_laborales.fecha_ingreso', 'desc')
            ->orderby('historias_laborales.id', 'desc')
            ->get()->first();


        $date = date('Y-m-d');
        $usuario['persona_id'] = $dataSubsuario != null ? $dataSubsuario->persona_id : 0;
        $usuario['identificacion_'] = $identificacion;
        $usuario['nombres_'] = $nombres_;
        $usuario['correo_institucional'] = $dataSubsuario != null ? $dataSubsuario->correo_institucional : '';
        $usuario['sigla_area'] = $dataSubsuario != null ? $dataSubsuario->sigla : '';
        $usuario['historia_laboral_id'] = $dataSubsuario != null ? $dataSubsuario->historia_laboral_id : 0;
        $usuario['areas_adicionales'] = $consultaAsignaciones;
        $usuario['jefe'] = $dataSubsuario != null ? $dataSubsuario->jefe : '';
        $usuario['persona_id_jefe'] = $datosJefes != null ? $datosJefes->persona_id : '--';
        $usuario['apellidos_nombres_jefe'] = $datosJefes != null ? $datosJefes->apellidos_nombres_ : '--';
        $usuario['nombre_area_jefe'] = $datosJefes != null ? $datosJefes->nombre_area : '--';
        $usuario['correo_institucional_jefe'] = $datosJefes != null ? $datosJefes->correo_institucional : null;
        $usuario['identificacion_jefe'] = $datosJefes != null ? $datosJefes->identificacion_ : null;
        $usuario['tipo_contrato'] = $dataSubsuario != null ? $dataSubsuario->tipo_contrato : ($dataSubsuario2 != null ? $dataSubsuario2->tipo_contrato : '');
        $usuario['nombres'] = is_null($cqlPersona) ? '' : $cqlPersona->nombres;
        $usuario['apellidos'] = is_null($cqlPersona) ? '' : $cqlPersona->apellidos;
        $usuario['area'] = $dataSubsuario != null ? $dataSubsuario->nombre_area : '';
        $usuario['cargo'] = $dataSubsuario != null ? $dataSubsuario->cargo : '';
        $usuario['fecha_ingreso'] = '';
        if (!is_null($cqlPersona)) {
            $fecha_ingreso = Historia_laboral::select('fecha_ingreso')
                ->where('persona_id', $cqlPersona->id)
                ->where('eliminado_por_reingreso', false)
                ->where('eliminado', false)
                ->orderBy('id', 'ASC')
                ->limit(1)->first();
            if (!is_null($fecha_ingreso))  $usuario['fecha_ingreso'] = $fecha_ingreso->fecha_ingreso;
        }
        $usuario['fecha_salida'] = '';
        if (!is_null($cqlPersona)) {
            $fecha_salida = Historia_laboral::select('fecha_salida')
                ->where('persona_id', $cqlPersona->id)
                ->where('eliminado_por_reingreso', false)
                ->where('eliminado', false)
                ->orderBy('id', 'ASC')
                ->limit(1)->first();
            if (!is_null($fecha_salida))  $usuario['fecha_salida'] = $fecha_salida->fecha_salida;
        }


        /**
         * Calculo Tiempo meses desde que ingreso hasta su salida
         * o fecha actual
         */
        $datetime1 = new DateTime($usuario['fecha_ingreso']);
        !is_null($usuario['fecha_salida']) ? $datetime2 = new DateTime($usuario['fecha_ingreso']) : $datetime2 = new DateTime('now');

        $interval = $datetime2->diff($datetime1);
        $intervalMeses = $interval->format("%m");
        $intervalAnos = $interval->format("%y") * 12;
        $tiempo_meses = $intervalMeses + $intervalAnos;
        // Fin calculo tiempo en meses

        $usuario['tiempo_meses'] = $tiempo_meses;
        $usuario['genero'] = $cqlPersona != null ? $cqlPersona->genero : '';
        $usuario['tipo_sangre'] = $cqlPersona != null ? $cqlPersona->tipo_sangre : '';
        $usuario['fecha_nacimiento'] = $cqlPersona != null ? $cqlPersona->fecha_nacimiento : '';

        return $usuario;
    }
}
