<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('teams','TeamController@teams');
Route::get('team-players/{teamID}','TeamController@teamPlayers');
Route::get('team-matches/{teamID}','MatchesController@teamMatches');
Route::get('team-name/{teamID}','TeamController@teamNameById');
Route::get('team-points/{teamID}','TeamController@teamPoints');

Route::post('team-add','TeamController@add');
Route::post('team-edit','TeamController@edit');
Route::delete('team/{teamId}','TeamController@delete');

Route::post('player-add','PlayerController@add');
Route::post('player-edit','PlayerController@edit');
Route::get('player-list','PlayerController@playerlist');

Route::post('assign-playerto-team','PlayerController@assignPlayerToTeam');
Route::get('available-players','PlayerController@availablePlayers');
Route::delete('remove-player-from-team','PlayerController@removePlayer');

Route::post('play-match','MatchesController@teamMatch');
Route::get('team-points-table','TeamController@teamPointsTable');


