<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partners extends Model
{
    //
    protected $fillable = [
        'name',
        'link',
        'image'
    ];
}
