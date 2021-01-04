<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    public function translations()
    {
        return $this->hasMany(TitleTranslation::class);
    }

    public function genres()
    {
        return $this->hasMany(Genre::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function people()
    {
        return $this->hasMany(Person::class);
    }

    public function meta()
    {
        return $this->hasMany(TitleMeta::class);
    }
}
