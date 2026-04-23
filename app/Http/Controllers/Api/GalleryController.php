<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index()
    {
        return response()->json(GalleryItem::with('file')->whereHas('file')->orderBy('sort_order')->get());
    }
}
