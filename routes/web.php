<?php

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

Route::get('/','HomeController@login');
/*Route::get('/', function () {
    return view('layout/login');
});*/

Route::post('/login','HomeController@validarUsuario')->name('login');

Route::post('/consulta-usuario','UsuarioController@consultaUsuario')->name('consulta-usuario');

Route::get('/home','HomeController@index')->name('home');
Route::get('/salir','HomeController@salir')->name('salir');


/*
 * Rutas para el USUARIO
 */
Route::get('/usuarios','UsuarioController@index')->name('usuarios');
Route::match(['get','post'],'/nuevo-usuario','UsuarioController@nuevoUsuario')->name('nuevo-usuario');
Route::match(['get','post'],'/editar-usuario/{id}','UsuarioController@editarUsuario')->name('editar-usuario');


/*
 * Rutas para Ventas
 */
Route::get('/ventas','VentasController@index')->name('ventas');
Route::group(['prefix'=>'ventas'],function(){
    Route::get('/nueva-venta','VentasController@nuevaVenta')->name('nueva-venta');
    Route::post('/registro-cliente','FacturacionController@crearCliente')->name('registro-cliente');
    Route::post('/autocomplete-cliente','FacturacionController@consultaAutocompleteCliente')->name('autocomplete-cliente');
    Route::post('/agregaitem','FacturacionController@agregaItem')->name('agregarItem');
    Route::post('/generarventa','FacturacionController@generarventa')->name('generarventa');
});


/*
 * Rutas Utilitarias
 */
Route::post('/util-documento','FacturacionController@cargaDocumentos')->name('util-documento');
Route::post('/consulta-ruc','FacturacionController@consultaRuc')->name('consulta-ruc');
