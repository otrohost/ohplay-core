<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponser;

class ApiController extends Controller
{
    use ApiResponser;

    public function notFound()
    {
        return $this->errorResponse(404, "This endpoint doesn't exist.");
    }

    public function language()
    {
        $languages = explode(",",config('services.languages.available'));
        $lang = isset($_GET['lang']) ? $_GET['lang'] : $languages[0];
        if(in_array($lang, $languages))
        {
            return $lang;
        }
    }
}
