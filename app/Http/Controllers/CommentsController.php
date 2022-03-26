<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class CommentsController extends BaseController
{
    public $model = Comment::class;
    public $modelClass;

    public function __construct()
    {
        $this->modelClass = new Comment();
    }

    public function getAll()
    {
        $data = $this->model::all();

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

    public function get($id)
    {
        $data = $this->model::where(['book_isbn' => $id])->get();

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

    public function post(Request $req)
    {
        $formData = $req->only(
            'comment',
            'book_isbn',
            'ip_address'
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
            'comment',
            'book_isbn',
            'ip_address'
        );

        // validate your input

        $this->validate($req, $this->modelClass->validation);
        $data['comment'] = $formData['comment'];
        $data['book_isbn'] = $formData['book_isbn'];
        $data['ip_address'] = $formData['ip_address'];
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
            'message' => 'comment has been deleted successfully',
            'data' => $data
        ])->setStatusCode(200);

    }


}
