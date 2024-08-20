<?php

namespace App\Http\Controllers;

use App\Events\ExcelExportEvent;
use App\Exports\FileExport;
use App\Exports\UsersExport;
use App\Jobs\ExportFilesJob;
use App\Models\File;
use App\Models\FileDownload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExportController extends Controller
{
    /**
     * Display available exports 
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('files.export_page');
    }
    /**
     * Exports All files using job no matter the user (parameter is used for broadcast)
     *
     * 
     * 
     */
    public function exportFilesJob() 
    {
        ExportFilesJob::dispatch(Auth::user());
        return back();
    }
    /**
     * Exports all files of both auth user and every user
     *
     *
     */
    public function exportFiles() 
    {
        $export_name = "Files_Export_". Carbon::now()->isoFormat('Y-M-D') .".xlsx";
        $files = File::select('users.name as user_name', 'files.*')
            ->leftJoin('users', 'users.id', '=', 'files.user_id')
            ->get();
            
        $param = [
            'user' => Auth::user(),
            'files' => $files,
            'export_name' => $export_name,
            'export_path' => storage_path("app/storage/files/exports/"  . $export_name),
            'count' => 1,
            'tab' => 2,
            'max'=> 1000, //can be removed
        ];
        $storedFile = Excel::store(new FileExport($param), "files/exports/" .  $export_name, 'storage');
        FileDownload::updateOrInsert(
            ['user_id' => Auth::id(), 'type' => 'ExcelExport'],
            ['name' => $export_name,
                'status' => false,
                'path' => $param["export_path"]
            ]
        );
        return response()->download($param["export_path"])->deleteFileAfterSend(true);
    }
    public function getExportInfo(Request $request) {
        return FileDownload::where('type', $request['type'])->where('user_id', $request['user_id'])->first();
    } 
    public function deleteExport(Request $request) {
        FileDownload::where('user_id', auth()->user()->id)->where("type", $request["type"])->delete();
        if (file_exists($request['path'])) {
            unlink($request['path']);
            return true;
        }
        return false;
    } 
    public function downloadExport(Request $request) {
        $file = FileDownload::where('user_id', Auth::id())->where('type', $request["type"])->firstOrFail();
        $file->status = true;
        $file->saveQuietly();
        return response()->download($request['path']);
    } 
}
