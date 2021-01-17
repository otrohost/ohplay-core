<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\ApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resources([
    'titles' => TitleController::class,
    'titles/contents' => ContentController::class,
    // 'users' => UserController::class,
    // 'users/times' => TimeController::class,
    // 'users/subscriptions' => SubscriptionController::class,
    // 'access_auth' => AccessController::class
]);

Route::get('/titles/genre/{genre_id}', [TitleController::class, 'indexAsGenre']);
Route::post('/titles/search/', [TitleController::class, 'search']);


// Route::post('/users/login/', 'UserController@login');
// Route::post('/users/logout/{id}', 'UserController@logout');
// Route::put('/users/password/{email}', 'UserController@password');

//404 routes
Route::fallback([ApiController::class, 'notFound']);


