<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'role',
        'image',
        'facebook',
        'twitter',
        'linkedin',
        'youtube',
        'rank',
        'position',
        'description'
    ];

    public function getImageUrl() {
        return $this->image && Storage::exists($this->image)
            ? asset('storage/'.$this->image) : asset('assets/images/team_placeholder.png');
    }
}
