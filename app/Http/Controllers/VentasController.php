<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function index(Request $request){
    	if(!$request->session()->has('user'))
			return redirect('/');
		$option = 'ventas';
    	return view('ventas/index',compact('option'));
    }

    public function nuevaVenta(Request $request){
    	if(!$request->session()->has('user'))
			return redirect('/');
		/**
		 * Cargado de items del carrito
		 */
		\Cart::session($request->session()->getId());
		$items = \Cart::getContent()->toArray();
		
		$option = 'ventas';
    	return view('ventas/nueva',compact('option','items'));
    }
}
