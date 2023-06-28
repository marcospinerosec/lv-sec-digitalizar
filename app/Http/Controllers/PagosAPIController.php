<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class PagosApiController extends Controller
{


    public static function getHttpHeaders(){

        $bearerToken = 'rDoyf7pwG5dmm7JobqCuht7TAAeGiDtX';
        $headers    =   [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'X-API-KEY ' .$bearerToken,
            ],
            'http_errors' => false,
        ];
        return $headers;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function debt()
    {
        $client = new Client();
        $url = "https://core.sandbox.simp2.com/api/v1/debt";

        $params = [
            //If you have any Params Pass here
        ];
        $api_key='rDoyf7pwG5dmm7JobqCuht7TAAeGiDtX';
        $headers = [
            'api-key' => $api_key,
            'Authorization' => 'X-API-KEY ' .$api_key,
            'Content-Type' => 'application/json',
        ];




        $client = new Client();

// Prepare Request
        $request = new Request('POST', $url, [

            'headers' => $headers,
            'verify'  => false,
        ]);

// Send Request
        $response = $client->send($request, [
            'body' => 'ABCDEF',
        ]);

// Read Response
        $response_body = (string)$response->getBody();
        var_dump($response_body);

        //return view('projects.apiwithkey', compact('responseBody'));
    }


}
