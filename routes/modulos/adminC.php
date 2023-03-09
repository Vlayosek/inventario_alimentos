<?php

use Illuminate\Support\Facades\Route;

Route::get('/firma/index', 'Admin\FirmaController@index');

Route::get('/', function () {
    return redirect('/login');
})->name('administracion');
Route::post('storage/create', 'StorageController@save')->name('storage.create');
Route::get('formulario', 'StorageController@index');
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

//Route::get('registrarse', 'Auth\LoginController@registrarse')->name('auth.registrarse');
//Route::post('registerstore', 'Auth\LoginController@registrarsestore');

//Editar Perfil


// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('admin/home', 'HomeController@index');
Route::post('admin/sessionAudita', 'HomeController@sessionAudita');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    //-----------Parametros-------------------------------------------------------------------------------------------------------------------
    Route::get('ParametroIndex', 'Admin\ParametroController@index')->name('parametro.create');
    Route::post('SaveParameter', 'Admin\ParametroController@SaveParameter');
    Route::post('ParameterEliminar', 'Admin\ParametroController@ParameterEliminar');
    Route::get('datatable-parameter/', 'Admin\ParametroController@getDatatable');

    //----------Opciones--------------------------------------------------------------------------------------------------------------------
    Route::post('SaveOpcion', 'Admin\MenuController@StoreOpcion');
    Route::post('MenuEliminar', 'Admin\MenuController@MenuEliminar');
    Route::get('datatable-menu/', 'Admin\MenuController@getDatatable');
    Route::get('datatable-option/', 'Admin\MenuController@getDatatableoption');
    //-------------Roles_Opciones-----------------------------------------------------------------------------------------------------------------

    Route::get('MenuCreate', 'Admin\MenuController@index')->name('menu.create');
    Route::post('MenuRoleEliminar', 'Admin\MenuController@MenuRoleEliminar');
    Route::post('/PermissionRole/', 'Admin\MenuController@PermissionRole');
    Route::post('/UpdateRoleP/', 'Admin\RolesController@UpdateRoleP');
    //------------------------------------------------------------------------------------------------------------------------------
    //Route::resource('permissions', 'Admin\PermissionsController');
    // Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::get('roles/trash/{id}', 'Admin\RolesController@trash')->name('roles.trash');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    //---------Administrador de Base-------------------------------------------------------------------------------------------------

    Route::get('AdminBaseIndex', 'Admin\AdministradorBaseController@AdminBaseIndex');
    Route::post('AdminBaseStore', 'Admin\AdministradorBaseController@AdminBaseStore');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/impersonate/{user_id}', 'HomeController@impersonate')->name('impersonate');
    Route::get('/impersonate_leave', 'HomeController@impersonate_leave')->name('impersonate_leave');
});

Route::get('UserState/{id}', 'Admin\UsersController@userstate')
    ->name('admin.userstate');
