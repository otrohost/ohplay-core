<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitleMeta extends Model
{
    protected $table = "titles_meta";

    public function titles()
    {
        return $this->belongsTo(Title::class);
    }
}
