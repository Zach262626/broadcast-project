<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDownload extends Model
{
    use HasFactory;
    protected $table = 'file_downloads';
    protected $fillable = ['name', 'status', 'type', 'path', 'user_id', 'updated_at', 'created_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}