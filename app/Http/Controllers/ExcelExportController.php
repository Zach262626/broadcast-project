<?php

namespace App\Http\Controllers;

use App\Events\ExcelExportEvent;
use App\Exports\FileExport;
use App\Exports\UsersExport;
use App\Jobs\ExportFilesJob;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * @param Request $request
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function exportFilesJob() 
    {
        ExportFilesJob::dispatch(Auth::user());
        return back();
    }
    /**
     * Exports all files of both auth user and every user
     *
     * @param Request $request
     * @return Maatwebsite\Excel\Facades\Excel
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
            'increments' => 10,
            'total' => 100,//count($files),
            'count' => 0,
            'tab' => 2,
        ];
        $storedFile = Excel::store(new FileExport($param), "files/exports/" .  $export_name, 'storage');
        return Excel::download(new FileExport($param), $export_name);
    }
}
