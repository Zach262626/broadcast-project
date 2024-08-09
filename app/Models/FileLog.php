<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileLog extends Model
{
    use HasFactory;
    protected $table = 'files_log';
    protected $fillable = ['file_id', 'name', 'description', 'type'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
