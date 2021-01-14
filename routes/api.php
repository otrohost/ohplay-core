<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TitleController;

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
    // 'users' => UserController::class,
    // 'users/times' => TimeController::class,
    // 'users/subscriptions' => SubscriptionController::class,
    // 'access_auth' => AccessController::class
]);

Route::get('/titles/genre/{genre_id}', [TitleController::class, 'TitlesAsGenre']);

// Route::post('/users/login/', 'UserController@login');
// Route::post('/users/logout/{id}', 'UserController@logout');
// Route::put('/users/password/{email}', 'UserController@password');



