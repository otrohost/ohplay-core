<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use DB;

class TitleCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function show($language)
    {
        try {
            $response = DB::table('titles')
            ->inRandomOrder()
            ->join('translations as title', 'titles.title', '=', 'title.id')
            ->select('titles.id', 'title.'.$language.' as title', 'cover_horizontal', 'cover_vertical')
            ->paginate()->toArray();
            $message = "Titles retrieved correctly.";
            $status_code = 1;
        } catch(\Illuminate\Database\QueryException $ex){ 
            $message = $ex->getMessage();
            $status_code = 0;
            $response = [];
        }

        return [
           'status_code' => $status_code,
           'message' => $message,
           'response' => $response
        ];
    }

    public function showAsGenre($id, $language)
    {
        try {
            $response = DB::table('titles')
            ->inRandomOrder()
            ->join('titles_genres', 'titles.id', '=', 'titles_genres.title_id')
            ->join('genres', 'titles_genres.genre_id', '=', 'genres.id')
            ->join('translations as title', 'titles.title', '=', 'title.id')
            ->join('translations as genre', 'genres.name', '=', 'genre.id')
            ->where('genre_id', '=', $id)
            ->select('titles.id', 'title.'.$language.' as title', 'genre.'.$language.' as genre', 'cover_horizontal', 'cover_vertical')
            ->paginate()->toArray();
            $message = "Titles of the choosed genre retrieved correctly.";
            $status_code = 1;
        } catch(\Illuminate\Database\QueryException $ex){ 
            $message = $ex->getMessage();
            $status_code = 0;
            $response = [];
        }

        return [
           'status_code' => $status_code,
           'message' => $message,
           'response' => $response
        ];
    }

}
