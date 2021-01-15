<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Http;

class TMDBApi extends Model
{
    public function service($request, $id, $lang)
    {
        return Http::get(config('services.tmdb.url').''.$request.'/'.$id.'?api_key='.config('services.tmdb.token').'&language='.$lang.'')
        ->json();
    }

    public function title($id, $kind, $languages){
        $titles = [];
        $descriptions = [];
        
        foreach($languages as $language)
        {
            $content = $this->service($kind, $id, $language);
            array_push($titles, $content['title']);
            array_push($descriptions, $content['overview']);
            $poster = $content['poster_path'];
            $backdrop = $content['backdrop_path'];
            $tmdb_id = $content['id'];
            $genres = $content['genres'];
            $year = 2008;
        }

        return [
        "titles" => $titles,
        "descriptions" => $descriptions,
        "tmdb_id" => $tmdb_id,
        "year" => $year,
        "backdrop" => $backdrop,
        "poster" => $poster,
        "genres" => $genres
        ];
    }   

    public function genre($id, $languages){
        $genres = [];
        
        foreach($languages as $language)
        {
            $content = $this->service('genre', $id, $language);
            array_push($genres, $content['name']);
        }

        return $genres;
    }   
}
