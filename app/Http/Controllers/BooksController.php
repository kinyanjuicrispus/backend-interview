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
            $data = json_decode($response->getBody());

            usort($data, "cmp");
        if (count($data) == 0) {
            return response()->json([
                'message' => 'data not found',
                'data' => $data
            ])->setStatusCode(404);
        }
        $booksWithCommentCount = array();
        foreach ($data as $datum){
            $commentCount = Comment::where('book_isbn',$datum->isbn)->count();
            $datum->commentCount = $commentCount;
            array_push($booksWithCommentCount, $datum);
        }

            return response()->json([
                'message' => 'Success',
                'data' => $booksWithCommentCount
            ])->setStatusCode(200);
        } catch (GuzzleException $e) {
            return response()->json([
                'message' => 'An error occurred',
                'data' => null
            ])->setStatusCode(500);
        }

    }


    public function getBookById($id)
    {
        try {
            $response = $this->client->request('GET', 'books/' . $id);

            $data = json_decode($response->getBody()->getContents(), true, JSON_UNESCAPED_SLASHES);

            return response()->json([
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
