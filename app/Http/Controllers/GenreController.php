<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use DB;

class GenreController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $language = $this->language();

        try {
            $response = DB::table('genres')
            ->join('translations as translation', 'genres.name', '=', 'translation.id')
            ->select('genres.id', 'translation.'.$language.' as name')
            ->get();
            $message = "Genres retrieved correctly.";
            $status_code = 1;
            $http_code = 200;
        } catch(\Illuminate\Database\QueryException $ex){ 
            $message = $ex->getMessage();
            $http_code = 500;
            $status_code = 0;
            $response = [];
        }
        
        if ($status_code)
        {
            return $this->successResponse($response, $message);
        }
        else
        {
            return $this->errorResponse($response, $message);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
