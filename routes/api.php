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


    Route::prefix('Guest')->namespace('Guest')->group(function(){
        Route::post('create','GuestController@create');
        Route::post('update','GuestController@update');
    });


    Route::prefix('Account')->namespace('Auth')->group(function(){
        Route::post('create','AuthController@create');

        Route::post('login','AuthController@login');

        Route::get('profile','AuthController@profile');

    //     // forget password / phone_number
    });

});
// end auth apis

// main apis
Route::prefix('Quran')->namespace('Quran')->group(function(){

    Route::get('getAll','QuranController@getAll');
    Route::get('getAllPersonTafir','QuranController@getAllPersonTafir');
    Route::get('getAllPersonAudio','QuranController@getAllPersonAudio');

    Route::get('getSurah/{numberOfSurah}','QuranController@getSurah');

    ////////////////////////////////////
    Route::get('quickAccess','QuranController@quickAccess');

    Route::get('getAllJuz','QuranController@getAllJuz');

    Route::get('getJuz/{numberOfJuz?}','QuranController@getJuz');

    Route::get('getTafsir/{numberOfSurah}/{idOfPerson}/{numberOfAyah?}','QuranController@getTafsir');
    Route::get('getAudio/{numberOfSurah}/{idOfPerson}/{numberOfAyah?}','QuranController@getAudio');

    Route::prefix("Account")->group(function(){
        Route::post("Saved",'QuranController@post_saved');
        Route::get("Saved",'QuranController@get_saved');
    });

    Route::prefix("Timing")->group(function(){
        Route::get('getPrayerTime/{lat}/{lng}','QuranController@getPrayerTime');
    });

});



Route::prefix('Service')->namespace('Service')->group(function(){
    Route::get('getAll','ServiceController@getAll');
    Route::post('getService/{id?}','ServiceController@getService');
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
