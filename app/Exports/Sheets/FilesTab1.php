<?php

namespace App\Exports\Sheets;

use App\Models\File;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class FilesTab1 implements FromView, WithTitle, ShouldAutoSize
{
    public function __construct(protected array $param)
    {
        $this->param['tab'] = 1;
    }
    
    public function view(): View
    {
        return view('files.export.files', [
            'param' => $this->param
        ]);
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return 'All Files';
    }
}
