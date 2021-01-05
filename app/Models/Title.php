<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function translations()
    {
        return $this->hasMany(TitleTranslation::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'titles_genres')->withPivot('title_id', 'genre_id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function people()
    {
        return $this->belongsToMany(Person::class, 'titles_people')->withPivot('title_id', 'person_id');
    }

    public function meta()
    {
        return $this->hasMany(TitleMeta::class);
    }
}
