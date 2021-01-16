<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Title;
use App\Http\Resources\TitleCollection;
use App\Http\Resources\TitleResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TitleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $title = new TitleCollection();
        $response = $title->show();
        if ($response['status_code'])
        {
            return $this->successResponse($response['response'], $response['message']);
        }
        else
        {
            return $this->errorResponse($response['http_code'], $response['message']);
        }
    }

    public function indexAsGenre($id)
    {
        $collection = new TitleCollection();
        if ($collection->showAsGenre($id)['status_code'])
        {
            return $this->successResponse($collection->showAsGenre($id)['response'], $collection->showAsGenre($id)['message']);
        }
        else
        {
            return $this->errorResponse(400, $collection->showAsGenre($id)['message']);
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
        $title = new Title();
        $response = $title->saveTitle($request["tmdb_id"], $request["type"]);

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
    public function show($request)
    {  
        try{
            $response = Title::findOrFail($id);
            return $this->successResponse($response, "Title retrieved correctly");
        }
        catch(ModelNotFoundException $e)
        {
            return $this->errorResponse(404, "The title you asked for doesn't exist");
        }
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
        $title = new Title();
        $response = $title->updateTitle($request["tmdb_id"], $request["type"]);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $title = new Title();
        $response = $title->removeTitle($id);

        if($response['status_code'])
        {
            return $this->successResponse([], $response['message'], $response['http_code']);   
        }
        else
        {
            return $this->errorResponse($response['http_code'], $response['message']);
        }
    }
}
