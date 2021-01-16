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
}
