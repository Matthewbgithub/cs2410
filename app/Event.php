<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'type', 'name', 'imagesrc', 'description', 'date', 'authorid', 'venue', 'hyperlink'
    ];
}
