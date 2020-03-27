<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use Greenter\Model\Client\Client;

class VentasController extends Controller
{
    public function index(Request $request){
    	if(!$request->session()->has('user'))
			return redirect('/');
		$option = 'ventas';
    	return view('ventas/index',compact('option'));
    }

    public function nuevaVenta(Request $request){

		$facturacion = new \App\Extras\Facturacion();
		$facturacion->setCliente([
			'tipo_doc_cliente'	=> 1,
			'nro_identificacion'=> '47551880',
			'nombres'			=> 'JUNIOR ALDAIR SILVA PORTOCARRERO'
		]);
		ddd($facturacion);

    	if(!$request->session()->has('user'))
			return redirect('/');
		/**
		 * Cargado de items del carrito
		 */
		\Cart::session($request->session()->getId());
		//dd(new \Cart);
		$items = \Cart::getContent()->toArray();
		
		$option = 'ventas';
    	return view('ventas/nueva',compact('option','items'));
	}
	
	public function mostrarVenta(Request $request){}
}
