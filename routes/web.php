<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });


Route::get('/', 'UploadController@create' );
Route::post('/', 'UploadController@upload' );
Route::get('/driveUpload', 'UploadController@driveUpload' );

Route::get('test', function() {
    dd(Storage::disk('google')->put('test.txt', 'MakersLog'));
});
