<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharactersController extends Controller
{
    public $model = Character::class;
    public $modelClass;

    public function __construct()
    {
        $this->modelClass = new Character();
    }

    public function getCharacterByBookId($id)
    {

        $characters = Character::where(['book_id' => $id])

            ->get();

        if (count($characters) == 0) {
            return response()->json([
                'message' => 'data not found',
                'data' => $characters
            ])->setStatusCode(404);
        }

        return response()->json([
            'message' => 'Success',
            'data' => $characters
        ])->setStatusCode(200);

    }

    public function post(Request $req)
    {
        $formData = $req->only(
            'character_name',
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




}
