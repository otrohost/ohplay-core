<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    public function profiles()
    {
        return $this->belongsTo(Profile::class);
    }
}
