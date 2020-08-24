<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* 

*/

// listar
Route::get('/administracion/usuario/getListarUsuarios', 'Administracion\UsersController@getListarUsuarios');

// guardar Usuario
Route::post('/administracion/usuario/setRegistrarUsuario', 'Administracion\UsersController@setRegistrarUsuario');

// Editar Usuario
Route::post('/administracion/usuario/setEditarUsuario', 'Administracion\UsersController@setEditarUsuario');

// Cambiar estado: Usuario
Route::post('/administracion/usuario/setCambiarEstadoUsuario', 'Administracion\UsersController@setCambiarEstadoUsuario');


// ROLES ****
Route::get('/administracion/rol/getListarRoles', 'Administracion\RolesController@getListarRoles');
Route::get('/administracion/rol/getListarPermisosByRol', 'Administracion\RolesController@getListarPermisosByRol');
Route::post('/administracion/rol/setRegistrarRolPermisos', 'Administracion\RolesController@setRegistrarRolPermisos');
Route::post('/administracion/rol/setEditarRolPermisos', 'Administracion\RolesController@setEditarRolPermisos');

// guardar Archivo
Route::post('/archivo/setRegistrarArchivo', 'FilesController@setRegistrarArchivo');

// TODO: se cambia el orden de llamado a las rutas
Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
  ->where('optional', '.*');