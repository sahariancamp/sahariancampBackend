<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Activity extends Model
{
    protected $guarded = [];

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::deleting(function ($activity) {
            $activity->file?->delete();
        });
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->file?->url;
    }
}
