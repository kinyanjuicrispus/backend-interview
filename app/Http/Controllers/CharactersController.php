<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

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


    public function get(Request $req)
    {
        $sort_by = $req->get('sort_by');
        $sort_by_order = $req->get('sort_by_order');
        $gender_filter = $req->get('gender_filter');
        try {
            $uri = 'characters';
            if(!empty($gender_filter)){
                $uri = $uri.'/?gender='.$gender_filter;
            }
            $response = $this->client->request('GET', $uri);
            if($response->getStatusCode() != 200){
                return response()->json([
                    'success'=> false,
                    'message' => 'An error occurred',
                    'data' => null
                ])->setStatusCode(500);
            }

            $data = json_decode($response->getBody());

            if (count($data) == 0) {
                return response()->json([
                    'success'=> false,
                    'message' => 'data not found',
                    'data' => $data
                ])->setStatusCode(404);
            }
            $charactersWithAge = array();
            $total_age = 0;
            foreach ($data as $datum){
                $age = calculateAge($datum->born, $datum->died);
                if($age != -1){
                    $total_age += $age;
                }
                $datum->ageInYears = $age;
                $charactersWithAge[] = $datum;
            }

            if($sort_by == 'name' && $sort_by_order == 'asc'){
                usort($charactersWithAge, 'name_sort_asc');
            }

            if($sort_by == 'name' && $sort_by_order == 'desc'){
                usort($charactersWithAge, 'name_sort_desc');
            }
            if($sort_by == 'gender' && $sort_by_order == 'asc'){
                usort($charactersWithAge, 'gender_sort_asc');
            }
            if($sort_by == 'gender' && $sort_by_order == 'desc'){
                usort($charactersWithAge, 'gender_sort_desc');
            }
            if($sort_by == 'age' && $sort_by_order == 'asc'){
                usort($charactersWithAge, 'age_sort_asc');
            }
            if($sort_by == 'age' && $sort_by_order == 'desc'){
                usort($charactersWithAge, 'age_sort_desc');
            }

            $dataWithMetaData = new \stdClass();
            $dataWithMetaData->totalMatch = count($charactersWithAge);
            $dataWithMetaData->totalAgeInYears = $total_age;
            $dataWithMetaData->totalAgeInMonths = $total_age / 12;
            $dataWithMetaData->characters = $charactersWithAge;
            return response()->json([
                'success'=> true,
                'message' => 'Success',
                'data' => $dataWithMetaData
            ])->setStatusCode(200);
        } catch (GuzzleException $e) {
            return response()->json([
                'success'=> false,
                'message' => 'An error occurred',
                'data' => null
            ])->setStatusCode(500);
        }

    }

    public function getCharacterById($id)
    {
        try {
            $response = $this->client->request('GET', 'characters/' . $id);
            if($response->getStatusCode() != 200){
                return response()->json([
                    'success'=> false,
                    'message' => 'An error occurred',
                    'data' => null
                ])->setStatusCode(500);
            }
            $data = json_decode($response->getBody());

            return response()->json([
                'success'=> true,
                'message' => 'Success',
                'data' => $data
            ])->setStatusCode(200);
        } catch (GuzzleException $e) {
            return response()->json([
                'success'=> false,
                'message' => 'Failed',
                'data' => null
            ])->setStatusCode(500);
        }
    }

}
