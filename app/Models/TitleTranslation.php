<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitleTranslation extends Model
{
    protected $table = "titles_translations";

    public function titles()
    {
        return $this->belongsTo(Title::class);
    }
}
