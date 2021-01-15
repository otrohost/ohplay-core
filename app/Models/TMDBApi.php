<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TMDBApi extends Model
{
    public function service($request, $id)
    {
        return Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.url').'/'.$request.'/'.$id.'')
            ->json()['results'];
    }

    public function movie($id){
        $this->service();
    }   

    
}
