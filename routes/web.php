<?php

use App\Events\UploadStatus;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SessionController;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Route;






Route::get('/', function () {
    return view('index');
});
Route::post('/test', function (Request $request) {
    $temp = $_POST['text'];
    UploadStatus::dispatch("$temp");
    return back();
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
Route::post('/show/files', [FileController::class, 'getFiles']);

Route::get('/chat/{id}', function ($id) {
    if ($id == auth()->user()->id) {
        return view('chating.chat1');
    }else {
        return redirect('/');
    }
});
