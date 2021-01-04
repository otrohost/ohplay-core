<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    public function titles()
    {
        return $this->belongsTo(Title::class);
    }

    public function meta()
    {
        return $this->hasMany(ContentMeta::class);
    }
}
