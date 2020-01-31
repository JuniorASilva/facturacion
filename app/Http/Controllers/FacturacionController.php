<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function cargaDocumentos(Request $request){
        if (!$request->session()->has('user'))
            return redirect('/');
        if($request->isMethod('post')){
            
        }else{
            return response()->json(['status' => 202, 'data' => [], 'message' => 'Error, consulte con su administrador']);
        }
    }
}
