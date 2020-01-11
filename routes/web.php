<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layout.login');
});


Route::post('/login', 'HomeController@validarUsuario')->name('login');
Route::get('/logout', 'HomeController@salir')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/usuarios', 'UsuarioController@index')->name('usuarios');
Route::get('/nuevo-usuario', 'UsuarioController@nuevoUsuario')->name('nuevo-usuario');
Route::match(['get', 'post'], '/nuevo-usuario', 'UsuarioController@nuevoUsuario');