<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = "people";

    public function titles()
    {
        return $this->belongsToMany(Title::class);
    }
}
