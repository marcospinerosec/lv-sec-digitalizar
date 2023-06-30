<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as LaravelResponse;
use Illuminate\Support\Facades\View;

class SoapService
{
    const CLIENT_TOKEN = 'rDoyf7pwG5dmm7JobqCuht7TAAeGiDtX';
    const URL ="https://core.sandbox.simp2.com/api/v1/debt";

    public static function getHttpHeaders(){

        $apikey = self::CLIENT_TOKEN;
        $headers    =   [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-API-KEY' => $apikey,
            ],
        ];
        return $headers;
    }



    public function hello($name)
    {
        return "Hello, $name!";
    }

    // Dentro del método del servicio SOAP
    public function getDebt($token, $code)
    {


        // Verificar si el token recibido coincide con el token almacenado
        if ($token === self::CLIENT_TOKEN) {
            // Realizar las operaciones o acciones requeridas
            $client = new Client(self::getHttpHeaders());

            $url = self::URL."/".$code;

            $response = $client->get($url);
            //var_dump($response);

            // Convierte el JSON a un arreglo asociativo
            $data = $response->getBody()->getContents();

            // Renderiza una vista utilizando los datos del arreglo
            $xml = View::make('get_debt',['data' => $data])->render();

            // Crea una respuesta XML
            $response = new Response($xml);
            $response->header('Content-Type', 'text/xml');

            return $response;


            //return 'Success';
        } else {
            return 'Invalid token';
        }
    }

    public function postDebt($token, $debt)
    {


        // Verificar si el token recibido coincide con el token almacenado
        if ($token === self::CLIENT_TOKEN) {
            // Realizar las operaciones o acciones requeridas

            function transformArray($array) {
                // Recorrer el array y realizar la transformación deseada
                foreach ($array as $key => $value) {
                    // Verificar si el valor es un array y tiene una única clave llamada "item"
                    if (is_array($value) && count($value) === 1 && isset($value['item'])) {
                        // Reemplazar el array con su contenido
                        $array[$key] = $value['item'];
                    }
                    // Verificar si el valor es un array y no está vacío
                    elseif (is_array($value) && !empty($value)) {
                        // Realizar una llamada recursiva para transformar el array interno
                        $array[$key] = transformArray($value);
                    }
                }

                return $array;
            }

            Log::info(print_r($debt, true));
            // Convertir el objeto stdClass a un objeto SimpleXMLElement
            $xmlString = json_encode($debt);
            Log::info(print_r($xmlString, true));
            $xmlObject = \simplexml_load_string($xmlString);

            Log::info(print_r($xmlObject, true));
            // Convertir el objeto SimpleXMLElement en un array asociativo
            $array = xmlToArray($xmlObject);
            Log::info(print_r($array, true));
// Realizar la transformación adicional en el array resultante
            $transformedArray = transformArray($array);
            Log::info(print_r($transformedArray, true));
// Convertir el array en JSON
            $debt = json_encode($transformedArray, JSON_PRETTY_PRINT);

            Log::info(print_r($debt, true));
            //Log::info(print_r(json_encode($debt, JSON_FORCE_OBJECT), true));

            /*$cliente = array( "first_name"=> " Marcos",
                "last_name"=> "Piñero",
                "extra"=> []);
            $body = array("code"=> "666","alternative_code"=> "1", "ccf_code"=> "111222","ccf_client_id"=> "666", "ccf_client_data"=> $cliente,"ccf_extra"=> [], "payment_methods"=> "all", "subdebts"=> [array(
                "unique_reference"=> "666",
                "amount"=> 6666.66,
                "due_date"=> "2023-04-04 00:00:00",
                "texts"=> [
                    [
                        "Texts"
                    ]
                ]
            )
            ]
            );*/



            $url = self::URL;

            $client = new Client(self::getHttpHeaders());

            $response = $client->post($url, [

                'body' => json_encode($debt),
            ]);

            //var_dump($response->getBody()->getContents());






            return $response->getBody()->getContents();


            //return 'Success';
        } else {
            return 'Invalid token';
        }
    }
}
