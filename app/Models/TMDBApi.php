<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Http;

class TMDBApi extends Model
{
    public function service($request, $lang = "en")
    {
        $response = Http::get(config('services.tmdb.url').''.$request.'?api_key='.config('services.tmdb.token').'&language='.$lang.'')
        ->json();

        //check if title exists on TMDB
        if(isset($response['status_code']))
        {
            return 0;
        }
        else{
            return $response;
        }
    }

    public function title($id, $kind, $languages){
        $titles = [];
        $descriptions = [];
        $genres = [];
        $people = [];
        $request = "$kind/$id";
        
        foreach($languages as $language)
        {
            $content = $this->service($request, $language);       
            
            //returning false response if movie doesn't exist in TMDB
            if(!$content)
            {
                return 0;
            }
            
            if($kind == 'movie')
            {
                array_push($titles, substr($content['title'], 0, 500));
                $year = explode('-', ''.$content['release_date'].'')[0];
            }
            else
            {
                array_push($titles, substr($content['name'], 0, 500));
                $year = explode('-', ''.$content['first_air_date'].'')[0];
            }
            array_push($descriptions, substr($content['overview'], 0, 500));
            $poster = $content['poster_path'];
            $backdrop = $content['backdrop_path'];
            $tmdb_id = $content['id'];
        }

        //check if genres are common to both TV Shows and Movies
        foreach($content['genres'] as $genre)
        {
            $genre_id = $genre['id'];
            $request = $this->service("genre/$genre_id");
            if(isset($request['id']))
            {
                array_push($genres, [
                    'id' => intval($genre['id'])
                ]);
            }
        }

        //add people
        $crew = $this->service("$kind/$id/credits")['crew'];
        $cast = $this->service("$kind/$id/credits")['cast'];

        foreach($crew as $person)
        {
            if($person['job'] == "Executive Producer" || $person['job'] == "Director")
            {
                array_push($people, $person);
            }
        }
        $people = array_merge($people, $cast);
        
        return [
        "titles" => $titles,
        "descriptions" => $descriptions,
        "tmdb_id" => $tmdb_id,
        "year" => $year,
        "backdrop" => $backdrop,
        "poster" => $poster,
        "genres" => $genres,
        "people" => $people
        ];
    }   

    public function episode($id, $season, $episode, $languages)
    {
        $titles = [];
        $descriptions = [];
        $request = "tv/$id/season/$season/episode/$episode";

        foreach($languages as $language)
        {
            $content = $this->service($request, $language);

            //returning false response if tv show doesn't exist in TMDB
            if(!$content)
            {
                return 0;
            }

            array_push($titles, substr($content['name'], 0, 500));
            array_push($descriptions, substr($content['overview'], 0, 500));
            $image = $content['still_path'];
        }

        return [
            "titles" => $titles,
            "sinopsis" => $descriptions,
            "image" => $image
            ];
    }

    public function genre($id, $languages){
        $genres = [];
        $request = "genre/$id";
        
        foreach($languages as $language)
        {
            $content = $this->service($request, $language);
            array_push($genres, $content['name']);
        }
        return $genres;
    }   

    public function person($id){
        $request = "person/$id";
        return $this->service($request, 'en')['name'];
    }   
}
