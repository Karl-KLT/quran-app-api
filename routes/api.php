<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('User')->group(function(){
    Route::post('createUser','AuthController@createUser');
    Route::post('updateUser','AuthController@updateUser');
});
// main apis
Route::prefix('Quran')->group(function(){

    Route::get('getAll','QuranController@getAll');











});
// end main apis
Route::fallback(function(){
    return response()->json([
        'apis' => [
            'User' => config('custom.apis.UserRoute'),
            'Quran' => config('custom.apis.QuranRoute')
        ],
        'message' => "api doesn't found, check type of api then try again",
        'status' => 404
    ],404);
})->name('fallback');
