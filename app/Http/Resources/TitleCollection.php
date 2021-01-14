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

    public static $wrap = 'titles';

    public function show()
    {
        return DB::table('titles')
        ->inRandomOrder()
        ->join('translations as title', 'titles.title', '=', 'title.id')
        ->select('titles.id', 'spa as title', 'cover_horizontal', 'cover_vertical')
        ->paginate()->toArray();
    }

    public function showAsGenre($id)
    {
        return DB::table('titles')
        ->inRandomOrder()
        ->join('titles_genres', 'titles.id', '=', 'titles_genres.title_id')
        ->join('genres', 'titles_genres.genre_id', '=', 'genres.id')
        ->join('translations as title', 'titles.title', '=', 'title.id')
        ->join('translations as genre', 'genres.name', '=', 'genre.id')
        ->where('genre_id', '=', $id)
        ->select('titles.id', 'title.spa as title', 'genre.spa as genre', 'cover_horizontal', 'cover_vertical')
        ->paginate()->toArray();
    }
}
