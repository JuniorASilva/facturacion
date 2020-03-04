<?php

namespace App\Http\Controllers;

use App\Models\Indentificacion;
use App\Models\Persona;
use App\Models\Empresa;
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
                'status'  => 202,
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
                $nueva_identificacion->id_empresa = 1; // Por defecto
                $nueva_identificacion->save();

                $data = $request->all();
                $data['id_persona'] = $persona->id;

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

    public function autocompleteCliente(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/');

        if (is_numeric($request->input('cliente'))) {
            $where = [
                ['i.nroidentificacion', 'like', $request->input('cliente') . '%']
            ];
        } else {
            $where = [
                ['p.apellidos', 'like', $request->input('cliente') . '%']
            ];
        }

        $where = $this->_prepareWhere($request->input('cod_doc'), $request->input('cliente'));

        if ($request->input('cod_doc') == '03') {
            $clientes = Persona::getClienteAutocomplete($where);
        } else {
            $clientes = Empresa::getClienteAutocomplete($where);
        }

        $resultados = [];

        if (!is_null($clientes)) {
            foreach($clientes as $cliente) {
                array_push($resultados, [
                    'value' => $cliente->nroidentificacion . '-' . $cliente->cliente,
                    'data' => $cliente
                ]);
            }
        }

        return response()->json([
            'suggestions' => $resultados
        ]);
    }

    public function _prepareWhere($cod_doc, $cliente='') {
        if (is_numeric($cliente)) {
            $where = [
                ['i.nroidetificacion', 'like', $cliente . '%']
            ];
        } else {
            if ($cod_doc == '03') {
                $where = [
                    ['p.apellidos', 'like', $cliente . '%']
                ];
            } else {
                $where = [
                    ['e.razon_social', 'like', $cliente . '%']
                ];
            }
        }
        return $where;
    }

    public function consultaRuc(Request $request)
    {
        $sunat = new \Sunat();
        $ruc = $request->input('ruc');

        $data = $sunat->getDataRUC($ruc);

        if ($data) {
            $data['ruc'] = $ruc;

            $emp = new Empresa();
            $emp->razon_social = $data['razon_social'];
            $emp->razon_social = $data['nombre_comercial'];
            $emp->razon_social = $data['direccion'];
            $emp->estado = 1;

            if ($emp->save()) {
                $ident = new Indentificacion();
                $ident->id_persona = 1;
                $ident->id_tipo_identificacion = 6;
                $ident->nroidentificacion = $data['ruc'];
                $ident->id_empresa = $emp->id;
                $ident->save();
                $data['id_empresa'] = $emp->id;
            } else {
                return response()->json([
                    'status'  => 202,
                    'data'    => [],
                    'message' => 'Error al almacenar los datos'
                ]);
            }

            return response()->json([
                'status'  => 200,
                'data'    => $data,
                'message' => 'Datos encontrados'
            ]);
        } else {
            return response()->json([
                'status'  => 202,
                'data'    => [],
                'message' => 'Datos no encontrados'
            ]);
        }
    }
}
