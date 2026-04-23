<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = ['path', 'disk', 'mime_type', 'size'];

    protected $appends = ['url'];

    protected static function booted()
    {
        static::deleting(function ($file) {
            if ($file->path) {
                Storage::disk($file->disk ?? config('filesystems.default'))->delete($file->path);
            }
        });
    }

    public function getUrlAttribute()
    {
        if (!$this->path) return null;
        
        // If the disk is specified, use it. Otherwise use default.
        return Storage::disk($this->disk ?? config('filesystems.default'))->url($this->path);
    }
}
