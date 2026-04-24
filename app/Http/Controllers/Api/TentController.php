<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tent;
use Illuminate\Http\Request;

class TentController extends Controller
{
    public function index()
    {
        $tents = Tent::with('file')->where('is_active', true)->get();

        return response()->json($tents);
    }
}
