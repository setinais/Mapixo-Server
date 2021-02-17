<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('file', function()
{
    $path = storage_path().'/'.'app'.'/public/app-release.apk';
    if (file_exists($path)) {
        return Response::download($path);
    }
})->name('file');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
