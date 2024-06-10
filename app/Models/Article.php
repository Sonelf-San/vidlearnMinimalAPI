<?php

namespace App\Models;
use App\Models\Logo;
use App\Models\ArtFile;
use App\Models\Category;
use App\Models\User;
use App\Models\Video;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    protected $fillable = ['name'];

    public function videos() {
        return $this->hasMany(Video::class);
    }


    public function incrementReadCount() {
        $this->reads++;
        return $this->save();
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getLogoUrl(){
        // asset('storage/logos/' . $article->logo->image)
        // dd($this->logo->image);
        return asset( 'assets/images/product-placeholder.png');
        // return $this->logo->image && Storage::exists('/logos/', $this->logo->image)
        //     ? asset('storage/logos/'.$this->logo->image) : asset('assets/images/product-placeholder.png');
    }
}
