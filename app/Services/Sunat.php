<?php

namespace App\Services;

class Sunat {

    private static $client;
    private static $response;

    public static function llamado($ruc = '')
    {
        if ($ruc == '')
            return false;

        $cl = new \GuzzleHttp\Client();
        $rs = $cl->request('GET', 'http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha', [
            'query' => 'accion=random'
        ]);

        if ($rs->getStatusCode() != 200) {
            return false;
        }
        $numRand = $rs->getBody()->getContents();
        
        self::$client = new \GuzzleHttp\Client();
        $data = [
            [
                'name' => 'nroRuc',
                'content'  => $ruc,
            ],
            [
                'name' => 'action',
                'content '=> 'consPorRuc',
                
            ],
            [
                'name' => 'numRand',
                'content' => $numRand
            ]
        ];

        self::$response = self::$client->request(
            'POST',
            'http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias',
            $data
        );

        return self::$response->getBody()->getContents();
    }
}