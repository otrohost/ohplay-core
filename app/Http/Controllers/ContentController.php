<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContentController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request["tmdb_id"]) && isset($request["season"]) && isset($request["episode"]) && isset($request["source"]))
        {
            $content = new Content();
            $response = $content->saveContent($request);
        }
        else
        {
            $response['status_code'] = 0;
            $response['http_code'] = 400;
            $response['message'] = "Parameters missing. TV shows must include at least: 'tmdb_id' of the parent title, 'season', 'episode' and 'source'.";
        }
        
        if ($response['status_code'])
        {
            return $this->successResponse([], $response['message'], $response['http_code']);
        }
        else
        {
            return $this->errorResponse($response['http_code'], $response['message']);
        }
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
