<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Title extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = ['title', 'sinopsis', 'tmdb_id', 'year', 'cover_horizontal', 'cover_vertical', 'type'];   

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'titles_genres')->withPivot('title_id', 'genre_id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function people()
    {
        return $this->belongsToMany(Person::class, 'titles_people')->withPivot('title_id', 'person_id');
    }

    public function translation($id,$lang)
    {
        return Translation::find($id)->$lang;
    }

    public function saveTitle($request)
    {
        $translation = new Translation();
        $genre = new Genre();

        $genres = [1];
        
        $title = Title::create(
            [
                'title' => $translation->createTranslation('spa', 'eng', 'por'),
                'sinopsis' => $translation->createTranslation('spa', 'eng', 'por'),
                'tmdb_id' => 2112,
                'year' => 2020,
                'cover_horizontal' => 'cover.jpg',
                'cover_vertical' => 'cover.jpg',
                'type' => 'movie'
            ]
        );

        foreach($genres as $genre_tmdb)
        {
            $title->genres()->save($genre->findOrCreateGenre($genre_tmdb));
        }

        return $title->id;
    }
}
