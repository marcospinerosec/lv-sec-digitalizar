<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as LaravelResponse;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\PagoController;


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

    public function copyAll($token)
    {
        if ($token === self::CLIENT_TOKEN) {
            try {
                // Llama a la función copyAll directamente desde el controlador
                $controller = new PagoController();
                $response = $controller->copyAll();

                // Puedes manejar la respuesta del controlador aquí si es necesario
                return $response;
            } catch (\Exception $e) {
                // Maneja excepciones si ocurren
                return 'Error: ' . $e->getMessage();
            }
        } else {
            return 'Invalid token';
        }
    }

    public function moveAll($token)
    {
        if ($token === self::CLIENT_TOKEN) {
            try {
                // Llama a la función moveAll directamente desde el controlador
                $controller = new PagoController();
                $response = $controller->moveAll();

                // Puedes manejar la respuesta del controlador aquí si es necesario
                return $response;
            } catch (\Exception $e) {
                // Maneja excepciones si ocurren
                return 'Error: ' . $e->getMessage();
            }
        } else {
            return 'Invalid token';
        }
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

            function convertStdClassToArray($stdClassObject) {
                $array = [];
                foreach ($stdClassObject as $key => $value) {
                    if (is_object($value)) {
                        $array[$key] = convertStdClassToArray($value);
                    } elseif (is_array($value)) {
                        $array[$key] = convertArray($value);
                    } elseif ($value !== '') {
                        $array[$key] = $value;
                    }
                }
                return $array;
            }

            function convertArray($array) {
                $newArray = [];
                foreach ($array as $item) {
                    if (is_object($item)) {
                        $newArray[] = convertStdClassToArray($item);
                    } elseif (is_array($item)) {
                        $newArray[] = convertArray($item);
                    } elseif ($item !== '') {
                        $newArray[] = $item;
                    }
                }
                return $newArray;
            }

            //Log::info(print_r($debt, true));

// Convertir el objeto stdClass a un array asociativo
            $debt = convertStdClassToArray($debt);
//$result = convertArray([$array]);

// Función para reemplazar "item" por números en los índices dentro de la subclave 'item'
            function replaceItemKeysWithNumbersInSubArray($array) {
                if (!is_array($array)) {
                    return $array;
                }

                $newArray = array();
                foreach ($array as $key => $value) {
                    if ($key === 'item') {
                        if (is_array($value)) {
                            $newSubArray = array();
                            foreach ($value as $itemValue) {
                                $newSubArray[] = replaceItemKeysWithNumbersInSubArray($itemValue);
                            }
                            $newArray[] = $newSubArray;
                        }
                    } else {
                        $newArray[$key] = is_array($value) ? replaceItemKeysWithNumbersInSubArray($value) : $value;
                    }
                }

                return $newArray;
            }

// Aplicar la función solo en la subclave 'item' de 'subdebts'
            $debt['subdebts']['item'] = replaceItemKeysWithNumbersInSubArray($debt['subdebts']['item']);

// Reemplazar el índice 'item' en 'subdebts'
            $debt['subdebts'] = array($debt['subdebts']['item']);


// Convertir el array en JSON
            //$debt = json_encode($result, JSON_PRETTY_PRINT);

            Log::info(print_r($debt, true));

            //Log::info(print_r(json_encode($debt, JSON_FORCE_OBJECT), true));

            /*$cliente = array( "first_name"=> " Marcos",
                "last_name"=> "Piñero",
                "extra"=> []);
            $debt = array("code"=> "666","alternative_code"=> "1", "ccf_code"=> "111222","ccf_client_id"=> "666", "ccf_client_data"=> $cliente,"ccf_extra"=> [], "payment_methods"=> "all", "subdebts"=> [array(
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
            );

            Log::info(print_r($debt, true));*/

            $url = self::URL;



            try {
                $client = new Client(self::getHttpHeaders());

                $response = $client->post($url, [

                    'body' => json_encode($debt),
                ]);


                // Manejar la respuesta si es exitosa
                $body = $response->getBody()->getContents();
            } catch (ClientException $e) {
                if ($e->hasResponse()) {
                    $response = $e->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($statusCode == 422) {
                        // Manejar el error 422 Unprocessable Entity
                        $body = $response->getBody()->getContents();
                        // Puedes analizar y trabajar con el contenido de la respuesta
                        // ...
                    } else {
                        // Manejar otros códigos de error
                        // ...
                    }
                }
            } catch (Exception $e) {
                // Manejar otras excepciones
                // ...
            }






            return $body;


            //return 'Success';
        } else {
            return 'Invalid token';
        }
    }
}
