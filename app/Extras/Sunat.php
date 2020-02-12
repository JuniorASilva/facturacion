<?php

namespace App\Extras;

class Sunat{
    public static function llamado(){
        /*$client = new \GuzzleHttp\Client(['base_uri' => 'https://jsonplaceholder.typicode.com/']);
        $response = $client->request('GET', 'todos');
        return json_decode($response->getBody()->getContents());*/
        return "llamada a sunat";
    }
}