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
        $tmdb_api = new TMDBAPI();

        $languages = ["es", "en", "pt"];
        $tmdb_id = $request["tmdb_id"];
        $type = $request["type"];

        $tmdb_content = $tmdb_api->title($tmdb_id, $type, $languages);

        $genres = $tmdb_content['genres'];

        $title = Title::create(
            [
                'title' => $translation->createTranslation($tmdb_content["titles"]),
                'sinopsis' => $translation->createTranslation($tmdb_content["descriptions"]),
                'tmdb_id' => $tmdb_content["tmdb_id"],
                'year' => $tmdb_content["year"],
                'cover_horizontal' => $tmdb_content["backdrop"],
                'cover_vertical' => $tmdb_content["poster"],
                'type' => $type
            ]
        );

        foreach($genres as $genre_tmdb)
        {   
            $title->genres()->save($genre->findOrCreateGenre($genre_tmdb['id'], $languages));
        }

    }
}
