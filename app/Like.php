<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $primaryKey = 'likesid';
    protected $fillable = [
        'authorid', 'id'
    ];
}
