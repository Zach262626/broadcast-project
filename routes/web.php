<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
});


Route::get('/upload',[FileController::class, 'index']);
Route::post('/upload', [FileController::class, 'upload']);
Route::get('/download', [FileController::class, 'show']);
Route::post('/download-multiple', [FileController::class, 'downloadMultiple']);
