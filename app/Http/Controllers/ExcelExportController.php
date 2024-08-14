<?php

namespace App\Http\Controllers;

use App\Exports\FileExport;
use App\Exports\UsersExport;
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
        return view('export.index');
    }
    /**
     * Exports all users files
     *
     * @param Request $request
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function exportAllFiles() 
    {
        return Excel::download(new FileExport, 'all.files.xlsx');
    }
    /**
     * Exports all auth user files
     *
     * @param Request $request
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function exportFiles() 
    {
        return Excel::download(new FileExport(Auth::user()), 'myfiles.xlsx');
    }

}
