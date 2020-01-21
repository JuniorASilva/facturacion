<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layout/login');
});

Route::post('/login','HomeController@validarUsuario')->name('login');

Route::post('/consulta-usuario','UsuarioController@consultaUsuario')->name('consulta-usuario');
Route::get('/home','HomeController@index')->name('home');
Route::get('/salir','HomeController@salir')->name('salir');

Route::get('/usuarios','UsuarioController@index')->name('usuarios');
Route::match(['get','post'],'/nuevo-usuario','UsuarioController@nuevoUsuario')->name('nuevo-usuario');
