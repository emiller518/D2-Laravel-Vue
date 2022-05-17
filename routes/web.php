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

Route::get('/class/','App\Http\Controllers\TestController@index');

//Route::get('/player/{id}', 'App\Http\Controllers\PlayerController@index');
Route::get('/team/{abbr}/{year}', 'App\Http\Controllers\TeamController@year');
Route::get('/game/{id}', 'App\Http\Controllers\GamesController@index');
Route::get('/standings/', 'App\Http\Controllers\StandingsController@index');

Route::get('/todoapp/', 'App\Http\Controllers\SandboxController@todo');
Route::get('/javascript/', 'App\Http\Controllers\SandboxController@js');


Route::get('/', function () {
    return view('welcome', ['test'=>'aaaa']);
});

Route::get('/player/{id}', 'App\Http\Controllers\PlayerController@playerProfile');
Route::get('/team/{abbr}', 'App\Http\Controllers\TeamController@year');
//Route::get('/team/{abbr}/{year}', 'App\Http\Controllers\TeamController@teamYear');
