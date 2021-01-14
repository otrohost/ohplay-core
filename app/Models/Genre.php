<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function titles()
    {
        return $this->belongsToMany(Title::class, 'titles_genres')->withPivot('genre_id', 'title_id');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}
