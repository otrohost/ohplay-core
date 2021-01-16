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

    public function existsTitle($id)
    {
        $title = Title::where('tmdb_id', '=', $id)->first();
        if($title !== null){
            return $title;
        }
        else
        {
            return 0;
        }
    }

    public function saveTitle($tmdb_id, $type)
    {
        $translation = new Translation();
        $genre = new Genre();
        $tmdb_api = new TMDBAPI();

        $languages = ["es", "en", "pt"];

        $title = $this->existsTitle($tmdb_id);

        //comprove if title already exists
        if($title)
        {
            $status_code = 0;
            $http_code = 409;
            $message = "The title you're trying to create already exists";
        }
        else
        {
            //obtain data from TMDB
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
            //comprove if the genres of the title exists on the database. If not, create them.
            foreach($genres as $genre_tmdb)
            {   
                $title->genres()->save($genre->findOrCreateGenre($genre_tmdb['id'], $languages));
            }
            $status_code = 1;
            $http_code = 201;
            $message = "The title has been created";
        }
        
        return [
            'status_code' => $status_code,
            'http_code' => $http_code,
            'message' => $message
        ];
    }


    public function removeTitle($tmdb_id)
    {
        $title = $this->existsTitle($tmdb_id);
        $translation = new Translation();

        //comprove if title exists before deleting
        if($title)
        {
            //remove title and genre relations
            $title->genres()->detach();
            $title->delete();

            //remove translations
            $translation->removeTranslation($title['title']);
            $translation->removeTranslation($title['sinopsis']);
            
            $status_code = 1;
            $http_code = 200;
            $message = "The title has been deleted successfully";
        }
        else
        {
            $status_code = 0;
            $http_code = 404;
            $message = "The title you're trying to delete doesn't exist";
        }

        return [
            'status_code' => $status_code,
            'http_code' => $http_code,
            'message' => $message
        ]; 
    }

    public function updateTitle($tmdb_id, $type)
    {
        $title = $this->existsTitle($tmdb_id);
        if($title) {
            $this->removeTitle($tmdb_id);
            $this->saveTitle($tmdb_id, $type);
            $status_code = 1;
            $http_code = 200;
            $message = "The title has been edited successfully";
        }
        else {
            $status_code = 0;
            $http_code = 404;
            $message = "The title you're trying to edit doesn't exist";
        }

        return [
            'status_code' => $status_code,
            'http_code' => $http_code,
            'message' => $message
        ];         
    }
}
