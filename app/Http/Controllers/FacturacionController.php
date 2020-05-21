<?php

namespace App\Http\Controllers;

use App\Models\Indentificacion;
use App\Models\Persona;
use App\Models\Empresa;
use App\Models\Items;
use App\Models\Utils;
use App\Models\Venta;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
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

        $where = $this->_prepareWhere($request->input('cod_doc'), $request->input('cliente'));

        if ($request->input('cod_doc') == '03') {
            $clientes = Persona::getClienteAutocomplete($where);
        } else {
            $clientes = Empresa::getClienteAutocomplete($where);
        }

        $resultados = [];

        if (!is_null($clientes)) {
            foreach ($clientes as $cliente) {
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

    public function _prepareWhere($cod_doc, $cliente = '')
    {
        if (is_numeric($cliente)) {
            $where = [
                ['i.nroidentificacion', 'like', $cliente . '%']
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

    public function agregarItem(Request $request)
    {
        Cart::session($request->session()->getId());

        $item = [
            'id'        => sha1($request->input('descripcion')),
            'name'      => $request->input('descripcion'),
            'price'   => $request->input('precio'),
            'quantity'  => $request->input('cantidad'),
            'attributes' => [
                'tipo_igv'  => $request->input('igv'),
                'tipo'      => $request->input('tipoitem'),
                'descuento' => $request->input('descuento'),
            ],
        ];

        Cart::add($item);

        return response()->json([
            'status' => 200,
            'data' => $item,
            'message' => 'Item agregado correctamente'
        ]);
    }

    public function generarVenta(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return redirect('/nueva-venta');
        }

        Cart::session($request->session()->getId());
        $usuario = $request->session()->get('user');
        // dd($usuario);

        try {
            $data_invoice = [
                'cod_doc'               => $request->input('tipo_doc'),
                'id_persona'            => $request->input('tipo_doc') == '03' ? $request->input('id_cliente') : 1,
                'id_empresa'            => $request->input('tipo_doc') == '01' ? $request->input('id_cliente') : 1,
                'id_usuario'            => $usuario['id'],
                'id_tipo_pago'          => 1,
                'id_moneda'             => $request->input('id_moneda'),
                'descuento'             => 0.0,
                'total'                 => Cart::getTotal(),
                'igv'                   => 0.18,
                'gravada'               => Cart::getTotal() - Cart::getTotal() * 0.18,
                'inafecta'              => 0,
                'exonerada'             => 0,
                'gratuita'              => 0,
                'valorigv'              => Cart::getTotal() * 0.18,
                'fecha_emision'         => date('Y-m-d H:i:s'),
                'fecha_pago'            => date('Y-m-d H:i:s'),
                'estado'                => 1
            ];
            $result = (new Venta())->newVenta($data_invoice);
            $data_invoice['num_serie'] = $result[0]->num_serie;
            $data_invoice['num_documento'] = $result[0]->num_documento;
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'data' => [], 'message' => 'Error en registrar la venta']);
        }

        $items = Cart::getContent()->toArray();
        foreach ($items as $item) {
            /**
             * Generar la funcionalidad para guardar los datos en tproducto
             */
            $i = new Items();
            $i->num_serie = $result[0]->num_serie;
            $i->num_documento = $result[0]->num_documento;
            $i->cod_doc = $request->input('tipo_doc');
            $i->id_producto = 1;
            $i->cantidad = $item['quantity'];
            $i->precioventa = $item['price'];
            $i->descuento = $item['attributes']['descuento'];
            $i->tipo_igv = $item['attributes']['tipo_igv'];
            $i->igv = 0.18;
            $i->valorigv = 1;
            $i->id_medida = 1;
            $i->cod_catalogo = '20001020';
            $i->save();
        }

        $facturacion = new \App\Services\Facturacion();
        $cliente = explode(' - ', $request->input('cliente'));
        $facturacion->setCliente([
            'tipo_doc_cliente'   => $request->input('cod_doc') == '03' ? 1 : 6,
            'nro_identificacion' => $cliente[0],
            'nombres'            => $cliente[1]
        ]);
        $facturacion->setInvoice($data_invoice);
        $facturacion->setItems($items);
        $res = $facturacion->end();

        return response()->json(['status' => 200, 'data' => [
            'resumen'       => $res,
            'comprobante'   => [
                'num_serie'         => $result[0]->num_serie,
                'num_documento'     => $result[0]->num_documento
            ],
        ], 'message' => 'Registro satisfactorio']);
    }

    public function quitaItem(Request $request)
    {
        Cart::session($request->session()->getId());
        if (Cart::remove($request->input('idItem')))
            return response()->json(['status' => 200, 'data' => [], 'message' => 'Item Eliminado']);
        return response()->json(['status' => 202, 'data' => [], 'message' => 'Datos no encontrados']);
    }

    public function cargaXml(Request $request, $comprobante)
    {
        $c = explode('-', $comprobante);
        $registroComprobante = Venta::getComprobante($c[0], $c[1]);
        $location = config('app.empresa.ruc') . '-' . $registroComprobante->cod_doc . '-' . $comprobante;
        $xml = file_get_contents(app_path() . '/../files/' . $location . '.xml');
        return \Response::make($xml, 200)->header('Content-Type', 'text/xml');
    }
}
