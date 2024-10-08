<?php

use App\Http\Controllers\CounterController;
use App\Http\Controllers\ExcelExportController;
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
/*
|--------------------------------------------------------------------------
| Authorization
|--------------------------------------------------------------------------
    */
Route::get('/signup', [SessionController::class, 'index']);
Route::post('/signup', [SessionController::class, 'create']);
Route::get('/logout', [SessionController::class, 'destroy']);
Route::get('/login', [SessionController::class, 'login']);
Route::post('/login', [SessionController::class, 'store']);


/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
    */
Route::get('/upload', [FileController::class, 'uploadIndex']);
Route::post('/upload', [FileController::class, 'upload'])->name('upload-files');
Route::get('/download', [FileController::class, 'downloadIndex']);
Route::get('/download-get', [FileController::class, 'getDownloadStatus'])->name('download_status');
Route::post('/download/path/delete', [FileController::class, 'deleteDownloadZip'])->name('download_zip_delete');
Route::post('/download', [FileController::class, 'download'])->name('download');
Route::post('/download-multiple', [FileController::class, 'downloadMultiple'])->name('download-multiple');
Route::post('/show/files', [FileController::class, 'getFilesNames']);
Route::post('/files/log', [FileController::class, 'logFiles'])->name('update-file-log');
Route::get('/files/log', [FileController::class, 'getLogFiles'])->name('old-logs');
/*
|--------------------------------------------------------------------------
| Count
|--------------------------------------------------------------------------
    */
Route::post('/count/start', [CounterController::class, 'startCounter'])->name('start_counter');
Route::post('/count/delete', [CounterController::class, 'deleteCounter'])->name('delete_counter');
Route::get('/count/status', [CounterController::class, 'getLatestCounter'])->name('counter_status_route');
/*
|--------------------------------------------------------------------------
| Excel Export
|--------------------------------------------------------------------------
    */
Route::get('/files/export_page', [ExcelExportController::class, 'index']);
Route::get('/files/export_page/files/job', [ExcelExportController::class, 'exportFilesJob'])->name('export-files-job');
Route::get('/files/export_page/files', [ExcelExportController::class, 'exportFiles'])->name('export-files');
Route::get('/files/export_page/get', [ExcelExportController::class, 'getExportInfo'])->name('get_export_info');
Route::post('/files/export_page/delete', [ExcelExportController::class, 'deleteExport'])->name('delete_export');
Route::post('/files/export_page/download', [ExcelExportController::class, 'downloadExport'])->name('download_export');




Route::get('/test', function () {
    return view('test');
});

Route::get('/auth/user', function () {
    return Auth::user();
})->name('getUser');
