<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('layout.login');
});*/
Route::get('/', 'HomeController@login');

Route::post('/login', 'HomeController@validarUsuario')->name('login');
Route::get('/logout', 'HomeController@salir')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');

/*
 * Rutas para el usuario 
 */
Route::post('/consulta-usuario', 'UsuarioController@consultaUsuario')->name('consulta-usuario');
Route::get('/usuarios', 'UsuarioController@index')->name('usuarios');
Route::match(['get', 'post'], '/nuevo-usuario', 'UsuarioController@nuevoUsuario')->name('nuevo-usuario');
Route::match(['get', 'post'], '/editar-usuario/{id}', 'UsuarioController@editarUsuario')->name('editar-usuario');


/*
Rutas para Ventas
*/

Route::get('/ventas', 'VentasController@index')->name('ventas');
Route::get('/nueva-venta', 'VentasController@nuevaVenta')->name('nueva-venta');
Route::post('/registro-cliente', 'FacturacionController@crearCliente')->name('registro-cliente');


/*
*Rutas Utilitarias
*/
Route::post('/util-documento','FacturacionController@cargaDocumentos')->name('util-documento');