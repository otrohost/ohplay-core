<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TMDBApi;
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
        return $this->belongsToMany(Person::class, 'titles_people')->withPivot('title_id', 'person_id', 'role');
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
        $person = new Person();
        $tmdb_api = new TMDBAPI();

        //get languages from env file
        $languages = explode(",",config('services.languages.available'));

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
            //get data from TMDB
            $tmdb_content = $tmdb_api->title($tmdb_id, $type, $languages);

            if($tmdb_content)
            {
                $genres = $tmdb_content['genres'];
                $people = $tmdb_content['people'];
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
                //check if genres of the title exists on the database. If not, create them.
                foreach($genres as $genre_tmdb)
                {   
                    $title->genres()->save($genre->findOrCreateGenre($genre_tmdb['id'], $languages));
                }

                //check if people exists on the database. If not, create them.
                foreach($people as $person_tmdb)
                {   
                    $findOrCreatePerson = $person->findOrCreatePerson($person_tmdb['id'], $person_tmdb['profile_path']);
                    $title->people()->save($findOrCreatePerson, ['role' => isset($person_tmdb['job']) ? $person_tmdb['job'] : 'Actor']);
                }

                $status_code = 1;
                $http_code = 201;
                $message = "The title has been created";
            } 
            else
            {
                $status_code = 0;
                $http_code = 404;
                $message = "The title you're trying to create doen't exist on TMDB";
            }
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
        $translations = [];

        //comprove if title exists before deleting
        if($title)
        {
            //save title translations
            array_push($translations, $title['title']);
            array_push($translations, $title['sinopsis']);

            //save contents translations
            $contents = $title->contents()->get();
            if(isset($contents[0]))
            {
                foreach($contents as $content)
                {
                    array_push($translations, $content['title']);
                    array_push($translations, $content['sinopsis']);
                }
            }

            //remove title and genre relations
            $title->delete();

            //remove translations
            if(isset($translations[0]))
            {
                foreach($translations as $translation_id)
                {
                    $translation->removeTranslation($translation_id);
                }
            }
            
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
