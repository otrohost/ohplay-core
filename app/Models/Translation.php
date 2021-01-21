<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    public $timestamps = false;

    public function findTranslation($id, $lang)
    {
        return Translation::find($id)->$lang;
    }

    public function createTranslation($strings)
    {
        $languages = explode(",",config('services.languages.available'));

        $translations = [];

        foreach ($strings as $key => $value)
        {
            $translations[$languages[$key]] = $value;
        }

        Translation::unguard();

        $translation = Translation::create(
            $translations
        );

        return $translation->id;
    }

    public function removeTranslation($id)
    {
        $translation = Translation::where('id', '=', $id)->first();
        return $translation->delete();
    }
}
