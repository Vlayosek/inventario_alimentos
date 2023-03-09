<?php

return [
	
	'user-management' => [
		'title' => 'Administrador',
		'created_at' => 'Time',
		'fields' => [
		],
	],
	
	'permissions' => [
		'title' => 'Permisos',
		'created_at' => 'Time',
		'fields' => [
			'name' => 'Name',
		],
	],
	
	'roles' => [
		'title' => 'Roles',
		'created_at' => 'Time',
		'fields' => [
			'name' => 'Name',
			'permission' => 'Permissions',
		],
	],
	
	'users' => [
		'title' => 'Usuarios',
		'created_at' => 'Time',
		'fields' => [
			'name' => 'Name',
			'email' => 'Email',
			'password' => 'Password',
			'roles' => 'Roles',
			'remember-token' => 'Remember token',
		],
	],
	'app_create' => 'Crear',
	'app_save' => 'Guardar',
	'app_edit' => 'Editar',
	'app_view' => 'Ver',
	'app_update' => 'Actualizar',
	'app_list' => 'Listado',
	'app_no_entries_in_table' => 'No existen datos',
	'custom_controller_index' => 'Custom controller index.',
	'app_logout' => 'Cerrar Sesión',
	'app_add_new' => 'Agregar Nuevo',
	'app_are_you_sure' => 'Esta Seguro ?',
	'app_back_to_list' => 'Listado Anterior',
	'app_dashboard' => 'Inicio',
	'app_delete' => 'Eliminar',
	'global_title' => 'EPACORE',
];