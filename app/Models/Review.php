<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'rating',
        'comment',
        'is_published',
        'stay_date',
        'source',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'stay_date' => 'date',
        'rating' => 'integer',
    ];
}
