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

// auth apis
Route::prefix('Auth')->group(function(){


    Route::prefix('Tokens')->group(function(){
        Route::post('createUser','Guest\GuestController@createUser');
        Route::post('updateUser','Guest\GuestController@updateUser');
    });


    Route::prefix('Accounts')->group(function(){
        Route::post('create','Auth\AuthController@create');

        Route::post('login','Auth\AuthController@login');

        Route::post('profile','Auth\AuthController@profile');

    //     // forget password / phone_number
    });




});
// end auth apis

// main apis
Route::prefix('Quran')->group(function(){

    Route::get('getAll','QuranController@getAll');
    Route::get('getAllPersonTafir','QuranController@getAllPersonTafir');
    Route::get('getAllPersonAudio','QuranController@getAllPersonAudio');

    Route::get('getSurah/{numberOfSurah}','QuranController@getSurah');
    Route::get('getTafsir/{numberOfSurah}/{idOfPerson}','QuranController@getTafsir');
    Route::get('getAudio/{numberOfSurah}/{idOfPerson}','QuranController@getAudio');

});
// end main apis

Route::fallback(function(){
    if(config('app.dev')){
        return response()->json([
            'apis' => [
                'User' => config('custom.apis.AuthRoute'),
                'Quran' => config('custom.apis.QuranRoute')
            ],
            'message' => "api doesn't found, check type of api then try again",
            'status' => 404
        ],404);
    }
    return response()->json([
        'message' => "error",
        'status' => 404
    ],404);
})->name('fallback');
