<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['tmdb_id', 'name'];  

    public function titles()
    {
        return $this->belongsToMany(Title::class, 'titles_genres')->withPivot('genre_id', 'title_id');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function findOrCreateGenre($tmdb_id)
    {
        $genre = Genre::where('tmdb_id', '=', $tmdb_id)->first();
        if ($genre !== null)
        {
            return $genre;
        }
        else
        {
            $translation = new Translation();
            return Genre::create(
                [
                    'tmdb_id' => $tmdb_id,
                    'name' => $translation->createTranslation('Género', 'Genre', 'Generillo')
                ]
            );
        }
    }



}
