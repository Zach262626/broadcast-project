<?php

namespace App\Exports\Sheets;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersTab implements FromView, WithTitle, ShouldAutoSize
{
    public function __construct(protected array $param)
    {
        $this->param['tab'] = 3;
    }
    
    public function view(): View
    {
        return view('files.export.files', [
            'param' => $this->param['user']
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
