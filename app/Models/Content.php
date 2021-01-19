<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = ['title', 'sinopsis', 'source']; 

    public function titles()
    {
        return $this->belongsTo(Title::class);
    }

    public function meta()
    {
        return $this->hasMany(ContentMeta::class);
    }

    public function saveContent($data)
    {
        $title = Title::where('tmdb_id', '=', $data['tmdb_id'])->first();
        $content_input = [];
        
        if($title['type'] == "movie")
        {
            $var = $title->contents();
            if(!$title->contents()->exists())
            {
                $content_input['title'] = $title['title'];
                $content_input['sinopsis'] = $title['sinopsis'];
                $content_input['source'] = $data['source'];
                $content = new Content($content_input);
                $title->contents()->save($content);
                if (count($data->all()) > 1)
                {
                    foreach($data->all() as $key => $value)
                    {
                        if($key != 'source' && $key != 'tmdb_id')
                        {
                            $content->meta()->save(new ContentMeta([
                                'meta_key' => $key,
                                'meta_value' => $value
                            ]));
                        }
                    }
                }
            }
            else{
                return [
                    'message' => "This movie already has a content with the following id: ".$title->contents()->first()['id'].". Try editing it instead"
                ];
            }
            
        }
        elseif ($title['type'] == "tv")
        {
            if(isset($data["season"]) && isset($data["episode"]) && isset($data["source"]))
            {
                $season = $data["season"];
                $episode = $data["episode"];
                $languages = ['es', 'en', 'pt'];
                if($title->contents()->exists())
                {
                    $contents = $title->contents()->with('meta')->get();
                    foreach($contents as $content)
                    {   
                        
                        foreach ($content['meta'] as $content_meta)
                        {
                            if($content_meta['meta_key'] == "season")
                            {
                                $content_season = $content_meta['meta_value'];
                            }
                            elseif($content_meta['meta_key'] == "episode")
                            {
                                $content_episode = $content_meta['meta_value'];
                            }
                        }
                        
                        if($content_season == $season && $content_episode == $episode)
                        {
                            return [
                                'message' => "The episode you're trying to add already exists"
                            ];
                        }
                    }
                }
                $translation = new Translation();
                $tmdbapi = new TMDBApi();
                $episode_info = $tmdbapi->episode($data["tmdb_id"], $data["season"], $data["episode"], $languages);
                $content_input['title'] = $translation->createTranslation($episode_info['titles']);
                $content_input['sinopsis'] = $translation->createTranslation($episode_info['sinopsis']);
                $content_input['source'] = $data["source"];

                $content = new Content($content_input);
                $title->contents()->save($content);

                $meta_add = $data->all();

                $meta_add['thumbnail'] = $episode_info['image'];

                foreach($meta_add as $key => $value)
                {
                    if($key != 'source' && $key != 'tmdb_id')
                    {
                        $content->meta()->save(new ContentMeta([
                            'meta_key' => $key,
                            'meta_value' => $value
                        ]));
                    }
                }
            }
            else{
                return [
                    'message' => "Arguments missing"
                ];
            }
        }
    }
}
