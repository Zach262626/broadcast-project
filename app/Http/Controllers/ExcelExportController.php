<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
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
     * Exports all users
     *
     * @param Request $request
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function exportUsers() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}
