<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $validated['booking_number'] = 'BK-' . strtoupper(Str::random(6));
        $validated['status'] = 'pending';

        $booking = Booking::create($validated);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }
}
