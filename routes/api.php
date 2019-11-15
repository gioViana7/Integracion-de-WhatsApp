<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'fb', 'as' => 'fb.'], function() {
        Route::post('/publish/post', 'PostController@publishFbPost')->name('post');
        Route::post('/upload/photo', 'PostController@uploadFbPhoto')->name('upload');
    });

    Route::group(['prefix' => 'cloudinary', 'as' => 'cloudinary.'], function() {
        Route::post('/signature', 'CloudinaryController@signature')->name('signature');
    });
});

