<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gameController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
Route::middleware(['auth:sanctum', 'auth-dev'])->group(function () {
    Route::post('/dev/new',  [gameController::class, 'RegisterGame']); //Register a new game
    Route::get('/dev/fetch',      [gameController::class, 'fetchKeys']);     //Fetch all the games
});

require __DIR__.'/auth.php';
