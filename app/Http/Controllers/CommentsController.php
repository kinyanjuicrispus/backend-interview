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

    public function get($id)
    {
        $data = $this->model::where(['book_id' => $id])->get();

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
            'book_id'
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
            'book_id'
        );

        // validate your input

        $this->validate($req, $this->modelClass->validation);
        $data['comment'] = $formData['title'];
        $data['book_id'] = $formData['author_id'];
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
            'message' => 'data has been succesfully',
            'data' => $data
        ])->setStatusCode(200);

    }


}
