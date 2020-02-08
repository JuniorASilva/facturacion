<?php

use Illuminate\Support\Facades\Route;

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
 * Rutas para las ventas
 */

Route::get('/ventas', 'VentasController@index')->name('ventas');
Route::get('/nueva-venta', 'VentasController@nuevaVenta')->name('nueva-venta');
Route::post('/crear-cliente', 'FacturacionController@crearCliente')->name('crear-cliente');
Route::post('/autocomplete-cliente', 'FacturacionController@autocompleteCliente')->name('autocomplete-cliente');

/**
 * Rutas Utiliarias
 */

Route::post('/util-documento', 'FacturacionController@cargaDocumentos')->name('util-documento');
Route::post('/cosulta-ruc', 'FacturacionController@consultaRuc')->name('consulta-ruc');