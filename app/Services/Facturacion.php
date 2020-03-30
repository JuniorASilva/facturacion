<?php

namespace App\Services;

/**
 * Llamo a clases de la libreria Greenter
 */

use DateTime;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\See;

use Greenter\Ws\Services\SunatEndpoints;
use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

/**
 * Clase encargada de gestionar los datos de la facturacion y generar el xml
 */
class Facturacion
{
    /*
    * @var Client
    */
    public $cliente;
    /*
    * @var Company
    */
    public $empresa;
    /*
    * @var Address
    */
    public $direccion;
    /*
    * @var Invoice
    */
    public $comprobante;
    /*
    * @var See
    */
    public $manejador;


    public function __construct()
    {
        $this->manejador = new See();
        $this->cliente = new Client();
        $this->empresa = new Company();
        $this->direccion = new Address();
        $this->comprobante = new Invoice();

        //Datos del emisor
        $this->direccion->setUbigueo(config('app.empresa.ubigeo'))
            ->setDepartamento(config('app.empresa.departamenta'))
            ->setProvincia(config(config('app.empresa.provincia')))
            ->setDistrito(config('app.empresa.distrito'))
            ->setDireccion(config('app.empresa.direccion'));

        $this->empresa->setRuc(config('app.empresa.ruc'))
            ->setRazonSocial(config('app.empresa.razon_social'))
            ->setNombreComercial(config('app.empresa.nombre_comercial'))
            ->setAddress($this->direccion);
        $this->comprobante->setCompany($this->empresa);

        //Cargando los certificados digitales
        $this->manejador->setService(config('app.empresa.certificado.endpoint') == 'test' ? SunatEndpoints::FE_BETA : SunatEndpoints::FE_PRODUCCION);
        $user = config('app.empresa.ruc') . config('app.empresa.usuario');
        $pass = config('app.empresa.password');
        $this->manejador->setCredentials($user, $pass);
        $this->cargaCertificado();
    }

    public function setCliente($cliente = [])
    {
        $this->cliente->setTipoDoc($cliente['tipo_doc_cliente'])
            ->setNumDoc($cliente['nro_identificacion'])
            ->setRznSocial($cliente['nombres']);

        $this->comprobante->setClient($this->cliente);
    }

    /**
     * Inserta todo el cuerpo del comprobante
     *
     * @param array $data
     * @return void
     */
    public function setInvoice($data = array())
    {
        $this->comprobante->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Catalog. 51
            ->setTipoDoc($data['cod_doc'])
            ->setSerie($data['num_serie'])
            ->setCorrelativo($data['num_documento'])
            ->setFechaEmision(new DateTime())
            ->setTipoMoneda('PEN')
            ->setMtoOperGravadas($data['gravada'])
            ->setMtoIGV($data['valorigv'])
            ->setTotalImpuestos($data['valorigv'])
            ->setValorVenta($data['gravada'])
            ->setSubTotal($data['total'])
            ->setMtoImpVenta($data['total']);
        //$this->comprobante->setLegends();
    }

    /**
     * Inserta todos los items al comprobante
     *
     * @param array $items
     * @return void
     */
    public function setItems($items = array())
    {
        $sales = [];
        foreach ($items as $item) {
            $sale = new SaleDetail();
            $sale->setCodProducto('P001')
                ->setUnidad('NIU')
                ->setCantidad($items['quantity'])
                ->setDescripcion($items['name'])
                ->setMtoBaseIgv($items['quantity'] * ($items['price'] - $items['price'] * 0.18))
                ->setPorcentajeIgv(18.00) // 18%
                ->setIgv($items['price'] * 0.18)
                ->setTipAfeIgv($items['attributes']['tipo_igv'] * 10)
                ->setTotalImpuestos($items['price'] * 0.18)
                ->setMtoValorVenta($items['quantity'] * ($items['price'] - $items['price'] * 0.18))
                ->setMtoValorUnitario($items['price'] - $items['price'] * 0.18)
                ->setMtoPrecioUnitario($items['price']);
            array_push($sales, $sale);
        }
        $this->comprobante->setDetails($sales);
    }

    /**
     * Firma y guarda el archivo xml
     *
     * @return void
     */
    public function end()
    {
        $xml = $this->manejador->getXmlSigned($this->comprobante);
        file_put_contents(app_path() . '/../files/' . $this->comprobante->getName() . '.xml', $xml);
    }
    private function cargaCertificado()
    {
        if (!file_exists(app_path() . '/../files/certificado.pem')) {
            //cargo el certificado completo
            $pfx = file_get_contents(app_path() . '/../files/' . config('app.empresa.certificado.directory'));
            $password = config('app.empresa.certificado.pin');
            $certificate = new X509Certificate($pfx, $password);
            //extraccion de certificado publico
            $pem = $certificate->export(X509ContentType::PEM);
            file_put_contents(app_path() . '/../files/certificado.pem', $pem);
        }
        $this->manejador->setCertificate(file_get_contents(app_path() . '/../files/certificado.pem'));
    }
}
