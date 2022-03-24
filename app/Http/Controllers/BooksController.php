<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class BooksController extends BaseController
{
    public $model = Book::class;
    public $modelClass;

    public function __construct()
    {
        $this->modelClass = new Book();
    }

    public function get()
    {
        $data = $this->model::
        with(['Author', 'Author'])
            ->withCount(['Comments', 'Comments'])
            ->get();

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
    }

    public function getBookById($id)
    {
        $data = $this->model::
        with(['Author', 'Author'])
            ->withCount(['Comments', 'Comments'])
            ->find($id);
        if (!$data) {
            return response()->json([
                'message' => 'data not found',
                'data' => $data
            ])->setStatusCode(404);
        }

        return response()->json([
            'message' => 'Success',
            'data' => $data
        ])->setStatusCode(200);
    }

    public function post(Request $req)
    {
        $formData = $req->only(
            'title',
            'author_id'
        );
        // validate your input

        $this->validate($req, $this->modelClass->validation);

        // try to insert
        $data = $this->modelClass;
        $data->fill($formData);
        $data->save();
        return response()->json([
            'message' => 'Success',
            'data' => $data
        ])->setStatusCode(200);
    }

    public function put(Request $req, $id)
    {
        $data = $this->model::find($id);
        // update the model

        if (!$data) {
            return response()->json([
                'message' => 'data not found',
                'data' => $data
            ])->setStatusCode(404);
        }

        $formData = $req->only(
            'title',
            'author_id'
        );
        // validate your input

        $this->validate($req, $this->modelClass->validation);
        $data['title'] = $formData['title'];
        $data['author_id'] = $formData['author_id'];
        // save to db
        $data->save();

        return response()->json([
            'message' => 'Success',
            'data' => $data
        ])->setStatusCode(200);
    }

    public function delete($id)
    {
        $data = $this->model::find($id);
        // update the model

        if (!$data) {
            return response()->json([
                'message' => 'data not found',
                'data' => $data
            ])->setStatusCode(404);
        }
        $data->delete();
        return response()->json([
            'message' => 'data has been successfully',
            'data' => $data
        ])->setStatusCode(200);

    }


}
