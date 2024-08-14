<?php

namespace App\Exports;

use App\Models\File;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class FileExport implements FromCollection
{
    public function __construct(User $user = null)
    {
        $this->user = $user;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->user) {
            return File::where('user_id', $this->user)->get();
        }
        return File::all();
    }
}
