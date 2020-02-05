<?php

namespace App\Http\Controllers;

use App\Models\Indentificacion;
use App\Models\Persona;
use App\Models\Utils;
use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function crearCliente(Request $request)
    {
        if (!$request->session()->has('user')) {
            return redirect('/');
        }
        
        $identificacion = Indentificacion::getIdentificacionPersona($request->input('tipo_documento'), $request->input('nro_doc'));

        if (count($identificacion) !== 0) {
            
            return response()->json([
                'status'  => 200,
                'data'    => [],
                'message' => 'Ya existe un registro con el numero de documento ' . $request->input('nro_doc')
            ]);
        } else {
            $persona = new Persona();
            $persona->nombres = $request->input('nombres');
            $persona->apellidos = $request->input('apellidos');
            $persona->fch_nac = date('Y-m-d'); // $request->input('fch_nac');
            $persona->direccion = $request->input('direccion');
            $persona->telefono = $request->input('telefono');
            $persona->genero = $request->input('genero');
            $persona->estado = 1;

            if ($persona->save()) {

                $nueva_identificacion = new Indentificacion();
                $nueva_identificacion->id_persona = $persona->id;
                $nueva_identificacion->id_tipo_identificacion = $request->input('tipo_documento');
                $nueva_identificacion->nroidentificacion = $request->input('nro_doc');
                $nueva_identificacion->id_empresa = 1; //
                $nueva_identificacion->save();

                $data = $request->all();
        
                return response()->json([
                    'status'  => 200,
                    'data'    => $data,
                    'message' => 'Registro satisfactorio' 
                ]);
            } else {
                return response()->json([
                    'status'  => 400,
                    'data'    => [],
                    'message' => 'Error consulta a su administrador'
                ]);
            }
        }
        
    }
    
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
