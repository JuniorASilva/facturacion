<?php

namespace App\Extras;

/**
 * Llamo a clases de la libreria Greenter
 */
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\See;

class Facturacion
{
    /**
     * Propiedad cliente
     *
     * @var Client
     */
    public $cliente;

    /**
     * Propiedad de los datos de mi empresa
     *
     * @var Company
     */
    public $empresa;

    /**
     * Propiedad de mi direccion como empresa
     *
     * @var Address
     */
    public $direccion;

    /**
     * Todo el comprobante que estoy generando
     *
     * @var Invoice
     */
    public $comprobante;

    /**
     * Permite manejar el comprobante
     *
     * @var See
     */
    public $manejador;

    public function __construct(){
        $this->manejador = new See();
        $this->cliente = new Client();
        $this->empresa = new Company();
        $this->direccion = new Address();
        $this->comprobante = new Invoice();

        //Datos del emisor
        $this->direccion->setUbigueo(config('app.empresa.ubigeo'))
                    ->setDepartamento(config('app.empresa.departamento'))
                    ->setProvincia(config('app.empresa.provincia'))
                    ->setDistrito(config('app.empresa.distrito'))
                    ->setDireccion(config('app.empresa.direccion'));
        $this->empresa->setRuc(config('app.empresa.ruc'))
                    ->setRazonSocial(config('app.empresa.razon_social'))
                    ->setNombreComercial(config('app.empresa.razon_social'))
                    ->setAddress($this->direccion);
    }

    public function setCliente($cliente = array()){
        $this->cliente->setTipoDoc($cliente['tipo_doc_cliente'])
                    ->setNumDoc($cliente['nro_identificacion'])
                    ->setRznSocial($cliente['nombres']);
        $this->comprobante->setClient($this->cliente);
    }
}
