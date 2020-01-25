<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentasController extends Controller
{
    //
    public function index(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/');

        $option = 'ventas';
        return view('ventas/index', compact('option'));
    }
}
