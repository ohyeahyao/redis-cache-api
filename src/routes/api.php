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
Route::group([
    'namespace' => '\App\Modules\Tutor\Controllers',
], function () {
    Route::get('tutors/{language_slug}', 'TutorController@tutorsBoard');
    Route::get('tutor/{tutor_slug}', 'TutorController@show');
});
