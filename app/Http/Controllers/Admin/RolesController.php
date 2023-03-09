<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use App\role_has_permission;
use App\Menu;
use DB;
use App\Http\Controllers\Ajax\SelectController;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use Auth;

class RolesController extends Controller
{
    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $permissions = Menu::get()->pluck('name', 'id');
        $roles = Role::get()->pluck('name', 'id');
        return view('admin.roles.index')->with(['roles' => $roles, 'permissions' => $permissions]); */


        $permissions1 =  DB::table('menus')->select(DB::RAW('UPPER(name)'), 'id')->where('parent', 0);
        $permissions = DB::table('menus as m1')
            ->join('menus as m', 'm1.id', 'm.parent')
            ->select(
                DB::raw("UPPER(CONCAT(m1.name,' -> ',m.name)) as name"),
                'm.id as id'
            )
            ->union($permissions1)
            ->orderby('id', 'asc')
            ->get()->pluck('name', 'id')->toArray();

        $roles = Role::get()->pluck('name', 'id');
        return view('admin.roles.index')->with(['roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $permissions1 =  DB::table('menus')->select(DB::RAW('UPPER(name)'), 'id')->where('parent', 0);
        $permissions = DB::table('menus as m1')
            ->join('menus as m', 'm1.id', 'm.parent')
            ->select(
                DB::raw("UPPER(CONCAT(m1.name,' -> ',m.name)) as name"),
                'm.id as id'
            )
            ->union($permissions1)
            ->orderby('id', 'asc')
            ->get()->pluck('name', 'id')->toArray();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolesRequest $request)
    {
        $intCod = Role::where('name', $request->name)->first();

        if ($intCod != null) {
            return redirect()->route('admin.roles.index');
        } else {
            $role = Role::create($request->except('permission'));
            /* $emp = Role::Find($role->id);
            $emp->save(); */
            foreach ($request->permission as $item) {
                DB::connection('pgsql')->table('role_has_permission')->insert(
                    ['role_id' => $role->id, 'menu_id' => $item]
                );
            }
        }


        return redirect()->route('admin.roles.index');
    }


    /* public function store(StoreRolesRequest $request)
    {
        $intCod = Role::where('name', $request->name)->first();

        if ($intCod != null || $request->permission == null) {
            return redirect()->route('admin.roles.index');
        } else {
            $role = Role::create($request->except('permission'));
            $emp = Role::Find($role->id);
            $emp->save();
            foreach ($request->permission as $item) {
                DB::connection('pgsql')->table('role_has_permission')->insert(
                    ['role_id' => $role->id, 'menu_id' => $item]
                );
            }
        }


        return redirect()->route('admin.roles.index');
    } */


    /**
     * Show the form for editing Role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $permissions = Menu::get()->pluck('name', 'id');
        $permissions1 =  DB::table('menus')->select(DB::RAW('UPPER(name)'), 'id')->where('parent', 0);
        $permissions = DB::table('menus as m1')
            ->join('menus as m', 'm1.id', 'm.parent')
            ->select(
                DB::raw("UPPER(CONCAT(m1.name,' -> ',m.name)) as name"),
                'm.id as id'
            )
            ->union($permissions1)
            ->orderby('id', 'asc')
            ->get()->pluck('name', 'id')->toArray();

        $objSelect = new SelectController();
        $array = $objSelect->getPermission($id, 'http');
        $role = Role::findOrFail($id);

        return view('admin.roles.edit')->with(['role' => $role, 'permissions' => $permissions, 'array' => $array]);
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateRoleP(request $request)
    {
        $role = DB::connection('pgsql')->table('roles')
            ->where(['name' => $request->name])->first();
        $lista = json_decode($request->permiso);

        foreach ($lista as $permiso) {
            $this->key   = 200;
            $this->value = "Grabado Exitosamente";

            $permissionE = DB::connection('pgsql')->table('role_has_permission')->where(['role_id' => $role->id, 'menu_id' => $permiso])->first();



            if ($permissionE != null) {
                $menu = Menu::where(['id' => $permissionE->menu_id])->get()->toArray();
                $this->key   = 300;
                $this->value = "Ya esta relacionado el item ," . $menu[0]['name'];
            } else {

                $result = DB::connection('pgsql')->table('role_has_permission')->insert(
                    //  ['role_id' => $role->id, 'menu_id' => $permiso,'empresa_id'=>Auth::user()->empresa_id]
                    ['role_id' => $role->id, 'menu_id' => $permiso]
                );
                if ($result > 0) {
                    $this->key   = 200;
                    $this->value = "Grabado Exitosamente";
                } else {
                    $this->key   = 300;
                    $this->value = "Existe un error contactarse con el administrador,";
                }
            }
        }
        return response()->json($this->value, $this->key);
    }


    /**
     * Remove Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index');
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {

        if ($request->input('ids')) {
            $entries = Role::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    public function trash($id)
    {
        try {
            $cqlDelete = role_has_permission::where('role_id', $id)->delete();
            $objEliminar = Role::where('id', $id)->delete();
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Eliminado Exitosamente ';
        } catch (\Exception $e) {
            $array_response['status'] = 404;
            $array_response['message'] = 'Error al Eliminar los datos porfavor consulte con el Administrador' . $e;
        }


        return redirect()->route('admin.roles.index');
    }
}
