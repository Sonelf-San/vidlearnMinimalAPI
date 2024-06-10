<?php

namespace App\Models;

use App\Models\Course;
use App\Models\School;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Logo extends Model
{
    //
    protected $fillable = [
        'name',
        'image'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

//    public function getLogoUrl(){
//        return $this->image && Storage::exists('/logos/', $this->image)
//            ? asset('storage/logos/'.$this->image) : asset('assets/images/product-placeholder.png');
//    }
}
