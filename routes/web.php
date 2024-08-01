<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Events\FileStatus;




Route::get('/', function () {
    return view('index');
});
Route::get('/test', function () {
    $temp = User::first();
    FileStatus::dispatch(User::first());
    event(new FileStatus($temp));
    return $temp;
});

Route::get('/signup', [SessionController::class, 'index']);
Route::post('/signup', [SessionController::class, 'create']);
Route::get('/logout', [SessionController::class, 'destroy']);
Route::get('/login', [SessionController::class, 'login']);
Route::post('/login', [SessionController::class, 'store']);

Route::get('/upload',[FileController::class, 'index']);
Route::post('/upload', [FileController::class, 'upload']);
Route::get('/download', [FileController::class, 'show']);
Route::post('/download-multiple', [FileController::class, 'downloadMultiple']);