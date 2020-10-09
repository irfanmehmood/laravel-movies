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

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ActorController;

Route::get('/', [MovieController::class, 'popular'])->name('movie.home');

Route::get('/popular', [MovieController::class, 'popular'])->name('movie.popular');
Route::get('/playing', [MovieController::class, 'playing'])->name('movie.playing');
Route::get('/toprated', [MovieController::class, 'toprated'])->name('movie.toprated');
Route::get('/upcoming', [MovieController::class, 'upcoming'])->name('movie.upcoming');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movie.show');


Route::get('/actor', [ActorController::class, 'index'])->name('actor.index');
Route::get('/actor/{id}', [ActorController::class, 'show'])->name('actor.show');
Route::get('/actor/page/{page?}{id}', [ActorController::class, 'index']);