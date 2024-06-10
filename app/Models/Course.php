<?php

namespace App\Models;

use App\Models\Logo;
use App\Models\ArtFile;
use App\Models\Category;
use App\Models\User;
use App\Models\Video;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }


    public function incrementReadCount() {
        $this->reads++;
        return $this->save();
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function logo() {
        return $this->belongsTo(Logo::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getLogoUrl(){
        return asset($this->logo && $this->logo->image ? 'storage/logos/'.$this->logo->image : 'assets/images/product-placeholder.png');
    }
}
