<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment',
        'ip_address',
        'book_id'
    ];

    public $validation = [
        'comment' => 'required',
        'ip_address' => 'required',
        'book_id' => 'required'
    ];
}
