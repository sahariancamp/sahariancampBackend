<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::where('is_active', true)->get()->map(function ($activity) {
            $activity->image_url = $activity->image ? asset('storage/' . $activity->image) : null;
            return $activity;
        });

        return response()->json($activities);
    }
}
