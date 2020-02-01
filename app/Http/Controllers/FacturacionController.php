<?php

namespace App\Http\Controllers;

use App\Models\Utils;
use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function cargaDocumentos(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/');

        $documentos = Utils::getDocumentos();

        return response()->json([
            'status'  => 200,
            'data'    => $documentos,
            'message' => 'Consulta satisfactoria'
        ]);
    }
}
