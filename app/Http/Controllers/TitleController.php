<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Title;

use App\Http\Resources\TitleCollection;

use App\Http\Resources\TitleResource;

class TitleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $collection = new TitleCollection();
        if ($collection->show()['status_code'])
        {
            return $this->successResponse($collection->show()['response'], $collection->show()['message']);
        }
        else
        {
            return $this->errorResponse(400, $collection->show()['message']);
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
        return $title->saveTitle($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new TitleResource( Title::findOrFail($id) );
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
