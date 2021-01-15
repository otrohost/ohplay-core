<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    public $timestamps = false;
    protected $fillable = ['spa', 'eng', 'por'];

    public function createTranslation($languages)
    {
        $translation = Translation::create(
            [
                'spa' => $languages[0],
                'eng' => $languages[1],
                'por' => $languages[2]
            ]
        );

        return $translation->id;
    }
}
