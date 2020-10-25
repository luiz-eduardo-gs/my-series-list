<?php

use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SeasonsController;
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

Route::get('/series', [SeriesController::class, 'index']);
Route::get('/series/create', [SeriesController::class, 'create']);
Route::post('/series', [SeriesController::class, 'store']);
Route::delete('/series/{serieId}', [SeriesController::class, 'destroy']);
Route::get('/series/{serieId}/seasons', [SeasonsController::class, 'index']);
Route::delete('/series/{serieId}/seasons/{seasonId}', [SeasonsController::class, 'destroy']);
Route::post('/series/{serieId}/seasons/{seasonId}', [SeasonsController::class, 'updateWatchedEpisodes']);