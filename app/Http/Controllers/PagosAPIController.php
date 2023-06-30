<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class PagosApiController extends Controller
{



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public static function getHttpHeaders(){

        $apikey = 'rDoyf7pwG5dmm7JobqCuht7TAAeGiDtX';
        $headers    =   [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-API-KEY' => $apikey,
            ],
        ];
        return $headers;
    }



    public function postDebt()
    {

        $cliente = array( "first_name"=> " Marcos",
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
        );


        $url = "https://core.sandbox.simp2.com/api/v1/debt";

        $client = new Client(self::getHttpHeaders());

        $response = $client->post($url, [

            'body' => json_encode($body),
        ]);

        var_dump($response->getBody()->getContents());
        //return view('projects.apiwithkey', compact('responseBody'));
    }


    public function getDebt()
    {

        $client = new Client(self::getHttpHeaders());

        $url = "https://core.sandbox.simp2.com/api/v1/debt/123";

        $response = $client->get($url);
        return $response->getBody()->getContents();
        //return view('projects.apiwithkey', compact('responseBody'));
    }




}
