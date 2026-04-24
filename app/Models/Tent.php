<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'features' => 'array',
    ];

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::deleting(function ($tent) {
            $tent->file?->delete();
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
