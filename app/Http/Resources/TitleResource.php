<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Translation;

class TitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    //adding language variable to constructor
    function __construct($resource, $lang){
        parent::__construct($resource);
        $this->lang = $lang;
    }

    public function genresArray()
    {
        $genres = [];
        $translation = new Translation();
        if(isset($this->genres)){
            foreach ($this->genres as $genre)
            {
                array_push($genres, [
                    'genre_id' => $genre->id,
                    'genre_title' =>  $translation->findTranslation($genre->name,$this->lang)
                ]);
            }
        }
        return $genres;
    }

    public function peopleArray()
    {
        $people = [];
        if(isset($this->people)){
            foreach ($this->people as $person)
            {
                array_push($people, [
                    'person_id' => $person->id,
                    'person_tmdbid' => $person->tmdb_id,
                    'person_name' =>  $person->name,
                    "person_role" => $person->role,
                    'person_image' =>  $person->img
                ]);
            }
        }
        return $people;
    }

    public function contentsArray()
    {
        $contents = [];
        $translation = new Translation();
        if(isset($this->contents)){
            foreach ($this->contents as $content)
            {
                $contentsmeta = [];
                
                if(isset($content->meta)){
                    foreach ($content->meta as $meta)
                    {
                        array_push($contentsmeta, [
                            $meta->meta_key => $meta->meta_value
                        ]);
                    }

                    array_push($contents, [
                        'content_id' => $content->id,
                        'content_uri' => $content->source,
                        'title' => $translation->findTranslation($content->title,$this->lang),
                        'sinopsis' => $translation->findTranslation($content->sinopsis,$this->lang),
                        'contents_meta' => $contentsmeta
                    ]);
                }
            }
        }
        return $contents;
    }

    public function toArray($request)
    {
        
        $translation = new Translation();

        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $translation->findTranslation($this->title,$this->lang),
            'sinopsis' => $translation->findTranslation($this->sinopsis,$this->lang),
            'cover_vertical' => $this->cover_vertical,
            'cover_horizontal' => $this->cover_horizontal,
            'TMDB' => $this->tmdb_id,
            'genres' => $this->genresArray(),
            'people' => $this->peopleArray(),
            'contents' => $this->contentsArray()
        ];

    }
}
