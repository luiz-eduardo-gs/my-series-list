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
Route::get('/series/{serieId}/seasons/create', [SeasonsController::class, 'create']);
Route::post('/series/{serieId}/seasons', [SeasonsController::class, 'store']);
Route::post('/series/{serieId}/seasons/{seasonId}/updateScore', [SeasonsController::class, 'updateScore']);
Route::post('/series/{serieId}/seasons/{seasonId}/updateTotalEpisodes', [SeasonsController::class, 'updateTotalEpisodes']);
Route::post('/series/{serieId}/seasons/{seasonId}/checkAll', [SeasonsController::class, 'checkAll']);
Route::delete('/series/{serieId}/seasons/{seasonId}', [SeasonsController::class, 'destroy']);
Route::post('/series/{serieId}/seasons/{seasonId}', [SeasonsController::class, 'updateWatchedEpisodes']);