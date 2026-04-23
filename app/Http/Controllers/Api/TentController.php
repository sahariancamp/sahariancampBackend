<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tent;
use Illuminate\Http\Request;

class TentController extends Controller
{
    public function index()
    {
        $tents = Tent::where('is_active', true)->get()->map(function ($tent) {
            $tent->image_url = $tent->image ? asset('storage/' . $tent->image) : null;
            $tent->features = json_decode($tent->features);
            return $tent;
        });

        return response()->json($tents);
    }
}
