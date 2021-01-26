<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = "people";
    protected $fillable = ['tmdb_id', 'name', 'img'];  

    public function titles()
    {
        return $this->belongsToMany(Title::class)->withPivot('title_id', 'person_id', 'role');
    }

    public function findOrCreatePerson($tmdb_id, $img)
    {
        $person = Person::where('tmdb_id', '=', $tmdb_id)->first();
        if ($person !== null)
        {
            return $person;
        }
        else
        {
            $tmdb_api = new TMDBApi();
            $person = $tmdb_api->person($tmdb_id);
            return Person::create(
                [
                    'tmdb_id' => $tmdb_id,
                    'name' => $person,
                    'img' => $img
                ]
            );
        }
    }
}
