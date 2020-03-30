<?php

namespace App\Http\Controllers;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Greenter\Model\Client\Client;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/');

        $option = 'ventas';

        return view('ventas.index', compact('option'));
    }

    public function nuevaVenta(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/');

        \Cart::session($request->session()->getId());
        $items = \Cart::getContent()->toArray();

        $option = 'ventas';

        return view('ventas.nuevos', compact('option', 'items'));
    }
}
