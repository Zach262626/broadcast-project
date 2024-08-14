<?php

namespace App\Exports;

use App\Exports\Sheets\FilesTab1;
use App\Exports\Sheets\FilesTab2;
use App\Exports\Sheets\UsersTab;
use App\Models\File;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FileExport implements WithMultipleSheets
{
    use Exportable;

    protected $user;

    public function __construct(protected array $param)
    {
        $this->user = $param["user"];
    }
    /**
    * 
    */
    public function sheets(): array
    {
        return [
            0 => new FilesTab1($this->param), 
            1 => new FilesTab2($this->param),
            //2 => new UsersTab(['user' => $this->user])
        ];
    }
}
