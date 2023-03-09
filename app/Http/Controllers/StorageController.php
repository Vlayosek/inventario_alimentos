<?php

namespace App\Http\Controllers;

use App\Core\Entities\Solicitudescj\Postulant;
use App\Core\Entities\Solicitudescj\ProductsPhoto;
use App\Core\Entities\Solicitudescj\StudentTeacher;


use App\Core\Entities\Solicitudescj\RequestPostulant;
use Illuminate\Http\Request;
use Auth;

class StorageController extends Controller
{
   public function index()
   {
      return \View::make('frontend.datos');
	  
   }
   public function fotosClinica(request $request)
   {
		$obj=ProductsPhoto::where([
		'model_id' => Auth::user()->id
		])->get()->count();
		$m="El limite de fotos es 6";

		$ccob=$obj+count($request->photos);
		
		if($obj<6 && $ccob<7)
		{
			foreach ($request->photos as $photo) {
				$filename = $photo->store('photos');
				ProductsPhoto::create([
					'model_id' => Auth::user()->id,
					'filename' => $filename
				]);
			}
			
			$m="Subida Exitosa";

		}
		$images=ProductsPhoto::where('model_id',Auth::user()->id)->get();
		$estudiante= Auth::user()->evaluarole(['estudiante']);
		$message='Aun no ha elegido Horario';
		$tipoM='warning';
		$objSt=StudentTeacher::where('user_est_id',Auth::user()->id)->get();
		
		$cc=0;
		$objSt1=$objSt->where('estado','A');
		if(count($objSt)!=0)
		{
			$message='Su seleccion de Horario está en proceso de revisiòn';
			$tipoM='warning';
			$cc=1;
			

		}
		if(count($objSt1)!=0)
		{
			$message='Su proceso de pasantias ha iniciado ';
			$tipoM='info';
			$cc=2;
		}
	return view('modules.Solicitudescj.student.clinica')->with(['m'=>$m,
	'images'=>$images,$estudiante=>'estudiante',
	$tipoM=>'tipoM',$message=>'message',$cc=>'cc']);

   }
   public function DeleteFoto(request $request)
   {

	\Storage::delete('photos/'.$request->filename);
	ProductsPhoto::where(['model_id'=>Auth::user()->id,'filename'=>$request->filename])->delete();
	$images=ProductsPhoto::where('model_id',Auth::user()->id)->get();
	$m="Eliminacion Exitosa";
	$estudiante= Auth::user()->evaluarole(['estudiante']);
	$message='Aun no ha elegido Horario';
		$tipoM='warning';
		$objSt=StudentTeacher::where('user_est_id',Auth::user()->id)->get();
		
		$cc=0;
		$objSt1=$objSt->where('estado','A');
		if(count($objSt)!=0)
		{
			$message='Su seleccion de Horario está en proceso de revisiòn';
			$tipoM='warning';
			$cc=1;
			

		}
		if(count($objSt1)!=0)
		{
			$message='Su proceso de pasantias ha iniciado ';
			$tipoM='info';
			$cc=2;
		}
		return view('modules.Solicitudescj.student.clinica')
		->with(['m'=>$m,'images'=>$images,$estudiante=>'estudiante',
		$tipoM=>'tipoM',$message=>'message',$cc=>'cc']);

   }
   
   public function save(Request $request)
	{		
		$civil=0;
		$penal=0;
		$laboral=0;
		$familia=0;
		$violenciaf=0;
		$inquilinato=0;
		$fiscalia=0;
		$defensoria=0;
		$constitucional=0;

		if(isset($request->civil))
		{
			$civil=1;	
		}
		if(isset($request->penal))
		{
			$penal=1;	
		}
		if(isset($request->laboral))
		{
			$laboral=1;	
		}
		if(isset($request->familia))
		{
			$familia=1;	
		}
		if(isset($request->violenciaf))
		{
			$violenciaf=1;	
		}
		if(isset($request->inquilinato))
		{
			$inquilinato=1;	
		}
		if(isset($request->constitucional))
		{
			$constitucional=1;	
		}
		if(isset($request->fiscalia))
		{
			$fiscalia=1;	
		}
		if(isset($request->defensoria))
		{
			$defensoria=1;	
		}
	$id=$request->idusuario;
	if($request->nivel=="EGRESADO")
	{
		$request->paralelo="-";
	}
	$objPostulant=Postulant::where('id',$id)->where('estado','A')->update([

	  "carrera" => $request->carrera,
      "modalidad" => $request->modalidad,
      "semestre" => $request->nivel,
      "paralelo" => $request->paralelo,
      "horario" => $request->horario,
      "identificacion" => $request->identificacion,
      "nombres" => $request->nombres,
      "apellidos" => $request->apellidos,
      "provincia_id" => $request->provincia,
      "ciudad_id" => $request->ciu,
      "direccion" => $request->direccion,
      "estado_civil" => $request->estado_civil,
      "edad" => $request->edad,
      "fecha_nacimiento" => $request->fecha_nacimiento,
      "correo" => $request->correo,
      "convencional" =>$request->convencional,
      "celular" => $request->celular,
      "labora" => $request->labora,
      "ocupacion" => $request->ocupacion,
      "horario_t" => $request->horario_t,
      "direccion_t" => $request->direccion_t,
      "telefono_t" => $request->telefono_t,
	  "discapacidad" =>$request->discapacidad,
	  "correo_institucional" =>$request->correo_institucional,
	  "civil" => $civil,
      "penal" => $penal,
      "laboral" => $laboral,
      "familia" => $familia,
      "violenciaf" => $violenciaf,
      "inquilinato" => $inquilinato,
      "fiscalia" => $fiscalia,
      "defensoria" => $defensoria,
      "constitucional" => $constitucional,
      "carnet" => $request->carnet,
	    "area" => $request->area
	  ]);
      		
		
		 //----------------------------------------Cedula
if($request->file('cedula')){
		$cedula = $request->file('cedula');
			\Storage::delete('cedula'.$id.'.pdf');
 		   \Storage::disk('local')->put('cedula'.$id.'.pdf',  \File::get($cedula));
		$objPostulant=Postulant::where('id',$id)->where('estado','A')->where('cedula_archivo',0)->update(['cedula_archivo'=>1]);
}
if($request->file('papeleta')){
$papeleta = $request->file('papeleta');
		   	\Storage::delete('papeleta'.$id.'.pdf');

		   \Storage::disk('local')->put('papeleta'.$id.'.pdf',  \File::get($papeleta));
		$objPostulant=Postulant::where('id',$id)->where('estado','A')->where('papeleta_archivo',0)->update(['papeleta_archivo'=>1]);
}
if($request->file('foto')){
 $foto = $request->file('foto');
			\Storage::delete('foto'.$id.'.pdf');
		 
			\Storage::disk('local')->put('foto'.$id.'.pdf',  \File::get($foto));
		$objPostulant=Postulant::where('id',$id)->where('estado','A')->where('foto_archivo',0)->update(['foto_archivo'=>1]);
}
if($request->file('curriculum')){
 $curriculum = $request->file('curriculum');
		   	\Storage::delete('curriculum'.$id.'.pdf');

		   \Storage::disk('local')->put('curriculum'.$id.'.pdf',  \File::get($curriculum));
		$objPostulant=Postulant::where('id',$id)->where('estado','A')->where('curriculum_archivo',0)->update(['curriculum_archivo'=>1]);
}
if($request->file('certificado_matricula')){
  $certificado_matricula = $request->file('certificado_matricula');
						\Storage::delete('certificado_matricula'.$id.'.pdf');

			\Storage::disk('local')->put('certificado_matricula'.$id.'.pdf',  \File::get($certificado_matricula));
		$objPostulant=Postulant::where('id',$id)->where('estado','A')->where('certificado_matricula',0)->update(['certificado_matricula'=>1]);
}
if($request->file('certificado_arrastre')){
$certificado_arrastre = $request->file('certificado_arrastre');
						\Storage::delete('certificado_arrastre'.$id.'.pdf');

			\Storage::disk('local')->put('certificado_arrastre'.$id.'.pdf',  \File::get($certificado_arrastre));
		$objPostulant=Postulant::where('id',$id)->where('estado','A')->where('certificado_no_arrastre',0)->update(['certificado_no_arrastre'=>1]);
}
if($request->file('solicitud_sellada')){
$solicitud_sellada = $request->file('solicitud_sellada');
	 	   			\Storage::delete('solicitud_sellada'.$id.'.pdf');

		   \Storage::disk('local')->put('solicitud_sellada'.$id.'.pdf',  \File::get($solicitud_sellada));
		$objPostulant=Postulant::where('id',$id)->where('estado','A')->where('solicitud_sellada',0)->update(['solicitud_sellada'=>1]);
}

		$objPostulant=Postulant::where('id',$id)
		->where('estado','A')
		->where('paralelo' ,'<>','')
		->where('identificacion' ,'<>','')
		->where('nombres' ,'<>', '')
		->where('apellidos' ,'<>', '')
		->where('provincia_id' ,'<>','')
		->where('ciudad_id' ,'<>', '')
		->where('direccion' ,'<>','')
		->where('edad' ,'<>','')
		->where('fecha_nacimiento' ,'<>','')
		->where('celular' ,'<>', '')
		->where('correo_institucional' ,'<>','')
		->where(
		['cedula_archivo'=>1,
		'papeleta_archivo'=>1,
		'foto_archivo'=>1,
		'curriculum_archivo'=>1,
		'certificado_matricula'=>1,
		'certificado_no_arrastre'=>1,
		'solicitud_sellada'=>1,
		])->get()->count();
		/*	$datos['data']=[
					 "carrera" => $request->carrera,
					  "modalidad" => $request->modalidad,
					  "semestre" => $request->nivel,
					  "paralelo" => $request->paralelo,
					  "horario" => $request->horario,
					  "identificacion" => $request->identificacion,
					  "nombres" => $request->nombres,
					  "apellidos" => $request->apellidos,
					  "provincia_text" => $request->provincia,
					  "ciudad_text" => $request->ciudad,
					  "direccion" => $request->direccion,
					  "estado_civil" => $request->estado_civil,
					  "edad" => $request->edad,
					  "fecha_nacimiento" => $request->fecha_nacimiento,
					  "correo" => $request->correo,
					  "convencional" =>$request->convencional,
					  "celular" => $request->celular,
					  "labora" => $request->labora,
					  "ocupacion" => $request->ocupacion,
					  "horario_t" => $request->horario_t,
					  "direccion_t" => $request->direccion_t,
					  "telefono_t" => $request->telefono_t,
					  "discapacidad" =>$request->discapacidad,
					  "carnet" => $request->carnet,
					  "area" => $request->area,
					  "correo_institucional" => $request->correo_institucional
								];*/
		if($objPostulant>0)
			{
				if($request->btnvg!=3)
				{
					$objRequestPostulant=RequestPostulant::where(['postulant_id'=>$id,'estado'=>'A'])->update(['state_id'=>1]);
				}
					
			}
		$message="Archivos Guardados Correctamente";
		$datos['message']=$message;
		$datos['printarchivo']="1";
		if($request->btnvg!=3)
		{
			return redirect()->route('frontend.home')->with($datos);	
		}else
		{
			return redirect()->route('admin.estudianteperfil')->with($datos);	

		}
	}
}
