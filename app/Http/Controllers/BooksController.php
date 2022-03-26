<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use GuzzleHttp\Exception\GuzzleException;
use Laravel\Lumen\Routing\Controller as BaseController;
use GuzzleHttp\Client;

class BooksController extends BaseController
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
            $response = $this->client->request('GET', 'books');
            if($response->getStatusCode() != 200){
                return response()->json([
                    'success'=> false,
                    'message' => 'An error occurred',
                    'data' => null
                ])->setStatusCode(500);
            }
            $data = json_decode($response->getBody());

            usort($data, "release_sort");

        if (count($data) == 0) {
            return response()->json([
                'success'=> false,
                'message' => 'data not found',
                'data' => $data
            ])->setStatusCode(404);
        }
        $booksWithCommentCount = array();
        foreach ($data as $datum){
            $commentCount = Comment::where('book_isbn',$datum->isbn)->count();
            $datum->commentCount = $commentCount;
            $booksWithCommentCount[] = $datum;
        }

            return response()->json([
                'success'=> true,
                'message' => 'Success',
                'data' => $booksWithCommentCount
            ])->setStatusCode(200);

        } catch (GuzzleException $e) {
            return response()->json([
                'success'=> false,
                'message' => 'An error occurred',
                'data' => null
            ])->setStatusCode(500);
        }

    }


    public function getBookById($id)
    {
        try {
            $response = $this->client->request('GET', 'books/' . $id);
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
                'message' => 'An error occurred',
                'data' => null
            ])->setStatusCode(500);
        }
    }

}
