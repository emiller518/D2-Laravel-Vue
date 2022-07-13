<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

/**
 * This file has been auto-namespaced to App\Http\Controllers\WWW
 *
 * @var Router $router
 */


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//TODO: Create API controllers and import logic
Route::get('/player/{id}', 'App\Http\Controllers\PlayerController@playerData');
Route::get('/team/{abbreviation}', 'App\Http\Controllers\TeamController@teamOverview');
Route::get('/playbyplay/getplaybyplayscore/{gameID}', 'App\Http\Controllers\PlayByPlayController@gamePlayByPlay');


$router->group(['prefix' => 'smb'], function(Router $router) {
    $router->get('/', 'TopSolarInstallersController@country');
    $router->get('/{state}', 'TopSolarInstallersController@state');
    $router->get('/{state}/{city}', 'TopSolarInstallersController@city');
});
