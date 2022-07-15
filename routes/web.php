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
Route::get('/team/{abbr}/{year}', 'App\Http\Controllers\Basketball\TeamController@year');
Route::get('/game/{id}', 'App\Http\Controllers\Basketball\GamesController@index');
Route::get('/standings/', 'App\Http\Controllers\Basketball\StandingsController@index');

Route::get('/todoapp/', 'App\Http\Controllers\SandboxController@todo');
Route::get('/javascript/', 'App\Http\Controllers\SandboxController@js');
Route::get('/vuechartjs/', 'App\Http\Controllers\SandboxController@vuechartjs');
Route::get('/chartjs/', 'App\Http\Controllers\SandboxController@chartjs');
Route::get('/d3/', 'App\Http\Controllers\SandboxController@d3');

Route::get('/smb/', 'App\Http\Controllers\SuperMegaBaseball\PlayerController@playerOverview');
Route::get('/smb/dummy', 'App\Http\Controllers\SuperMegaBaseball\PlayerController@playerOverview');


Route::get('/', function () {
    return view('welcome', ['test'=>'aaaa']);
});

Route::get('/player/{id}', 'App\Http\Controllers\Basketball\PlayerController@playerProfile');
Route::get('/team/{abbr}', 'App\Http\Controllers\Basketball\TeamController@year');
//Route::get('/team/{abbr}/{year}', 'App\Http\Controllers\TeamController@teamYear');
