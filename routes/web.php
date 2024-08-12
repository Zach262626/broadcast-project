<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\SessionController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
// Route::post('/test', function (Request $request) {
//     $temp = $_POST['text'];
//     UploadStatus::dispatch('$temp', Auth::id());
//     return back();
// });

Route::get('/signup', [SessionController::class, 'index']);
Route::post('/signup', [SessionController::class, 'create']);
Route::get('/logout', [SessionController::class, 'destroy']);
Route::get('/login', [SessionController::class, 'login']);
Route::post('/login', [SessionController::class, 'store']);

Route::get('/upload', [FileController::class, 'uploadIndex']);
Route::post('/upload', [FileController::class, 'upload'])->name('upload-files');
Route::get('/download', [FileController::class, 'downloadIndex']);
Route::post('/download', [FileController::class, 'download'])->name('download');
Route::post('/download-multiple', [FileController::class, 'downloadMultiple'])->name('download-multiple');
Route::post('/show/files', [FileController::class, 'getFiles']);

Route::get('/auth/user', function () {
    return Auth::user();
})->name('getUser');
