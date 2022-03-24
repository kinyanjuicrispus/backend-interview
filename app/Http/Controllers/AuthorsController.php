<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthorsController extends BaseController
{
    public $model = Author::class;
    public $modelClass;

    public function __construct()
    {
        $this->modelClass = new Author();
    }

    public function get()
    {
        $datas = $this->model::get();
        return response()->json([
            'message' => 'Success',
            'data' => $datas
        ])->setStatusCode(200);
    }

    public function post(Request $req)
    {
        $formData = $req->only(
            'author_name'
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
            'author_name'
        );
        // validate your input

        $this->validate($req, $this->modelClass->validation);
        $data['author_name'] = $formData['author_name'];
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
