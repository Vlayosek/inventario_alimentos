<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Http\Controllers\Ajax\SelectController;
use App\Core\Entities\Solicitudes\Empleados;
use Illuminate\Support\Facades\Input;

use DB;
use Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->sortByDesc("created_at");
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::get()->pluck('name', 'name');
        $objSelect = new SelectController();
        $tipo_id = $objSelect->getParametro('TIPOUSUARIO', 'http');

        return view('admin.users.create')->with(['roles' => $roles,'tipo_id'=>$tipo_id]);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
   {
       $rules = [
            'name' => 'required',
            'email' => 'required'
        ];
        $messages = [
            'name.required' => 'Escriba el nombre ',
            'email.unique' => 'El email es requerido',
        ];
        $this->validate($request, $rules, $messages);
            $user = User::create($request->all());
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->assignRole($roles);
        return redirect()->route('admin.users.index');
    }


    public function edit($id)
    {
        $roles = Role::get()->pluck('name', 'name');

        $user = User::findOrFail($id);
       $objSelect = new SelectController();
        $tipo_id = $objSelect->getParametro('TIPOUSUARIO', 'http');


        return view('admin.users.edit')->with([
            'user'=>$user,
            'roles'=>$roles,
            'tipo_id'=>$tipo_id
        ]);
    }


    public function update(UpdateUsersRequest $request, $id)
    {
        if($id==0)
        {
            $result = DB::connection('pgsql')
            ->table('users')
            ->where('name', $request->name)
            ->orwhere('email', $request->email)
            ->get()->toArray();
            if (count($result) > 0) {
                $users = User::all()->sortByDesc("created_at");
                $m='El usuario ya esta registrado';
                return view('admin.users.index', compact('users','m'));
            }
            $user = User::create($request->all());
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->assignRole($roles);

      }else{
          $user = User::findOrFail($id);
          $user->update($request->all());
          $roles = $request->input('roles') ? $request->input('roles') : [];
          $user->syncRoles($roles);
      }
      $id=$user->id;

         if($request->foto!=null){
             foreach ($request->foto as $foto)
                {
                    //Subir documento al repositorio
                    $file      = $foto;
                    $extension = $file->getClientOriginalExtension();
                    $nameFile  = 'USUARIO_'.'_'.$user->id.'_'.uniqid().'.'.$extension;
                    \Storage::disk('local')->put("USUARIOS/$nameFile",  \File::get($file));
                }

              $usuario=User::Find($id);
              $usuario->foto = $nameFile;
              $usuario->save();
         }
         if(Auth::user()->evaluarole(['administrator'])==true){
             return redirect()->route('admin.users.index');
         }else{
            return redirect()->route('administracion');
         }
    }

    public function destroy($id)
    {

        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }
    public function userstate($id)
    {
        $user = User::findOrFail($id);
        if($user->estado=='A')
        {
            $user->estado='I';
        }else
        {
            $user->estado='A';
        }
        $user->save();

        return redirect()->route('admin.users.index');
    }
    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }



}
