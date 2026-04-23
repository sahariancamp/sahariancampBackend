<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return response()->json(\App\Models\GalleryItem::orderBy('sort_order')->get());
    }
}
