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
        $translation = new Translation();        
        $content_input = [];

        if($title['type'] == "movie")
        {
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
        else
        {
            return [
                'status_code' => 0
            ];
        }
    }
}
