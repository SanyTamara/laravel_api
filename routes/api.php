<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\saveController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'auth-game'])->group(function () {
    Route::get('/save',           [saveController::class, 'getAll']);     //Fetch all the user save files
    Route::get('/save/file/{id}', [SaveController::class, 'load']);       //Load Data from the selected savve file
    Route::post('/save/new',      [SaveController::class, 'newSave']);    //Create a new Save file
    Route::put('/save/ow/{id}',   [SaveController::class, 'overwrite']);  //Overwrite the selected save file
    Route::delete('/save/d/{id}', [SaveController::class, 'delete']);     //Delete selected save file
});