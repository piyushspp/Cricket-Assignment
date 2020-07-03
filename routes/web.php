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

Route::get('register', 'AuthController@register');
Route::get('home', 'CricketController@home');
Route::get('team-detail/{teamId}', 'CricketController@team');
Route::get('team-matches-summary/{teamId}','MatchesController@teamMatchesSummary');
Route::get('team-total-points/{teamId}','TeamController@teamTotalPoints');

Route::get('team', 'TeamController@addTeam');
Route::get('team/{teamId}', 'TeamController@editTeam');
Route::get('player', 'PlayerController@addPlayer');
Route::get('player/{playerId}', 'PlayerController@editPlayer');
Route::get('player-list', 'PlayerController@allPlayers');
Route::get('add-playerto-team/{teamId}', 'PlayerController@addPlayerToTeam');

Route::get('match', 'MatchesController@executeMatch');
Route::get('team-points-table', 'TeamController@getTeamPointTable');
Route::get('phpunit', 'CricketController@phpunit');



