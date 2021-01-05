<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public static $wrap = 'title';

    public function toArray($request)
    {
        $genres = [];
        $people = [];
        $contents = [];
        $titlesmeta = [];

        if(isset($this->genres)){
            foreach ($this->genres as $genre)
            {
                array_push($genres, [
                    'genre_id' => $genre->id,
                    'genre_tmdbid' => 3234,
                    'genre_title' =>  $genre->name
                ]);
            }
        }
        
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
                        'content_uri' => $content->source,
                        'contents_meta' => $contentsmeta
                    ]);
                }
            }
        }

        if(isset($this->meta)){
            foreach ($this->meta as $meta)
            {
                array_push($titlesmeta, [
                    $meta->meta_key => $meta->meta_value
                ]);
            }
        }

        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'cover' => $this->cover,
            'TMDB' => $this->tmdb_id,
            'genres' => $genres,
            'people' => $people,
            'titles_meta' => $titlesmeta,
            'contents' => $contents
        ];
    }
}
