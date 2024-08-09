<?php

namespace App\Models;

use App\Models\User;
use App\Models\FileLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;
    protected $table = 'files';
    protected $fillable = ['name','path', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}