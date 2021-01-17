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

    public function genresArray()
    {
        $genres = [];
        $translation = new Translation();
        if(isset($this->genres)){
            foreach ($this->genres as $genre)
            {
                array_push($genres, [
                    'genre_id' => $genre->id,
                    'genre_title' =>  $translation->findTranslation($genre->name,"spa")
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
            'title' => $translation->findTranslation($this->title,"spa"),
            'sinopsis' => $translation->findTranslation($this->sinopsis,"spa"),
            'cover_horizontal' => $this->cover_horizontal,
            'TMDB' => $this->tmdb_id,
            'genres' => $this->genresArray(),
            'people' => $this->peopleArray(),
            'contents' => $this->contentsArray()
        ];

    }
}
