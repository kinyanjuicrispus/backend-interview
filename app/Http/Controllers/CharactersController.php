<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CharactersController extends Controller
{
    private $base_api_url;
    private $client;

    public function __construct() {
        $this -> base_api_url  = config('api-config.base_api_url');
        $this -> client = new Client([
            'base_uri' => $this->base_api_url
        ]);
    }


    public function get()
    {
        try {
            $response = $this->client->request('GET', 'characters');
            $data = json_decode($response->getBody()->getContents(),true, JSON_UNESCAPED_SLASHES);

            if (count($data) == 0) {
                return response()->json([
                    'message' => 'data not found',
                    'data' => $data
                ])->setStatusCode(404);
            }

            return response()->json([
                'message' => 'Success',
                'data' => $data
            ])->setStatusCode(200);
        } catch (GuzzleException $e) {
            return response()->json([
                'message' => 'Failed',
                'data' => null
            ])->setStatusCode(500);
        }

    }

    public function getCharacterById($id)
    {
        try {
            $response = $this->client->request('GET', 'characters' . $id);
            $data = json_decode($response->getBody()->getContents(), true, JSON_UNESCAPED_SLASHES);

//            if (count($data) == 0) {
//                return response()->json([
//                    'message' => 'data not found',
//                    'data' => $data
//                ])->setStatusCode(404);
//            }

            return response()->json([
                'message' => 'Success',
                'data' => $data
            ])->setStatusCode(200);
        } catch (GuzzleException $e) {
            return response()->json([
                'message' => 'Failed',
                'data' => null
            ])->setStatusCode(500);
        }
    }

}
