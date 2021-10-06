<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::post('/authenticate/login', 'Auth\LoginController@login');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/authenticate/logout', 'Auth\LoginController@logout');
    Route::get('/authenticate/getRefrescarUsuarioAutenticado', function() {
      return Auth::user()->load('file');
    });

    // USUARIOS    ****
    // listar

    Route::get('/administracion/usuario/getListarRolPermisosByUsuario', 'Administracion\UsersController@getListarRolPermisosByUsuario');
    Route::get('/administracion/usuario/getListarUsuarios', 'Administracion\UsersController@getListarUsuarios');
    // guardar Usuario
    Route::post('/administracion/usuario/setRegistrarUsuario', 'Administracion\UsersController@setRegistrarUsuario');
    // Editar Usuario
    Route::post('/administracion/usuario/setEditarUsuario', 'Administracion\UsersController@setEditarUsuario');
    // Cambiar estado: Usuario
    // SETTERS
    Route::post('/administracion/usuario/setCambiarEstadoUsuario', 'Administracion\UsersController@setCambiarEstadoUsuario');
    Route::put( '/administracion/usuario/setEditarRolByUsuario', 'Administracion\UsersController@setEditarRolByUsuario');
    Route::post('/administracion/usuario/setRegistrarPermisosByUsuario', 'Administracion\UsersController@setRegistrarPermisosByUsuario');
    // GETTERS
    Route::get( '/administracion/usuario/getRolByUsuario', 'Administracion\UsersController@getRolByUsuario');
    Route::get( '/administracion/usuario/getListarPermisosByRolAsignado', 'Administracion\UsersController@getListarPermisosByRolAsignado');
    Route::get( '/administracion/usuario/getListarPermisosByUsuario', 'Administracion\UsersController@getListarPermisosByUsuario');



    // ROLES    ****
    Route::get('/administracion/rol/getListarRoles', 'Administracion\RolesController@getListarRoles');
    Route::get('/administracion/rol/getListarPermisosByRol', 'Administracion\RolesController@getListarPermisosByRol');
    Route::post('/administracion/rol/setRegistrarRolPermisos', 'Administracion\RolesController@setRegistrarRolPermisos');
    Route::post('/administracion/rol/setEditarRolPermisos', 'Administracion\RolesController@setEditarRolPermisos');

    // PERMISOS ****
    Route::get('/administracion/permiso/getListarPermisos', 'Administracion\PermissionsController@getListarPermisos');
    Route::post('/administracion/permiso/setRegistrarPermiso', 'Administracion\PermissionsController@setRegistrarPermiso');
    Route::post('/administracion/permiso/setEditarPermiso', 'Administracion\PermissionsController@setEditarPermiso');

    // guardar Archivo
    Route::post('/archivo/setRegistrarArchivo', 'FilesController@setRegistrarArchivo');

    // modulo para CATEGORIAS
    Route::get('/configuracion/categoria/getListarCategorias', 'Configuracion\CategoriaController@getListarCategorias');
    Route::post('/configuracion/categoria/setRegistrarCategoria', 'Configuracion\CategoriaController@setRegistrarCategoria');
    Route::post('/configuracion/categoria/setEditarCategoria', 'Configuracion\CategoriaController@setEditarCategoria');

    // Modulo para PRODUCTOS
    Route::get('/configuracion/producto/getListarProductos', 'Configuracion\ProductoController@getListarProductos');
    Route::post('/configuracion/producto/setRegistrarProducto', 'Configuracion\ProductoController@setRegistrarProducto');
    Route::post('/configuracion/producto/setEditarProducto', 'Configuracion\ProductoController@setEditarProducto');

    // Modulo para OPERACIONES - PEDIDOS - CLIENTE
    Route::get('/operacion/pedido/getListarPedidos', 'Operacion\OrdersController@getListarPedidos');
    Route::get('/operacion/cliente/getListarClientes', 'Operacion\CustomersController@getListarClientes');
    Route::post('/operacion/cliente/setRegistrarCliente', 'Operacion\CustomersController@setRegistrarCliente');
    Route::post('/operacion/cliente/setEditarCliente', 'Operacion\CustomersController@setEditarCliente');
    Route::post('/operacion/pedido/setRegistrarPedido', 'Operacion\OrdersController@setRegistrarPedido');
    Route::post('/operacion/pedido/setCambiarEstadoPedido', 'Operacion\OrdersController@setCambiarEstadoPedido');
    Route::post('/operacion/pedido/setGenerarEmail', 'Operacion\OrdersController@setGenerarEmail');

    // GRAFICOS
    Route::get('/dashboard/getProductosMasVendidos', 'DashboardController@getProductosMasVendidos');
    Route::get('/dashboard/getVentasPorDia', 'DashboardController@getVentasPorDia');

    // Generacion PDF - EXCEL
    Route::post('/operacion/pedido/setGenerarDocumento', 'Operacion\OrdersController@setGenerarDocumento');

    // Chats
    Route::get('/chat/getListarContactos', 'ChatsController@getListarContactos');

});


// TODO: se cambia el orden de llamado a las rutas
Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
  ->where('optional', '.*');
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
