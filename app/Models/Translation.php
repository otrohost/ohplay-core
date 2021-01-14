<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    public $timestamps = false;
    protected $fillable = ['spa', 'eng', 'por'];

    public function createTranslation($spa, $eng, $por)
    {
        $translation = Translation::create(
            [
                'spa' => $spa,
                'eng' => $eng,
                'por' => $por
            ]
        );

        return $translation->id;
    }
}
