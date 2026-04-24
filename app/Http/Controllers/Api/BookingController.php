<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReceived;
use App\Mail\NewBookingNotification;
use App\Models\Tent;
use App\Models\User;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_type' => 'required|in:individual,agency',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $validated['booking_number'] = 'BK-' . strtoupper(Str::random(6));
        $validated['status'] = 'pending';

        $items = $validated['items'];
        unset($validated['items']);

        $booking = Booking::create($validated);

        // Process booking items
        foreach ($items as $item) {
            $tent = Tent::find($item['id']);
            if ($tent) {
                $price = ($validated['booking_type'] === 'agency' && $tent->agency_price) ? $tent->agency_price : $tent->price_per_night;
                
                $booking->items()->create([
                    'bookable_type' => Tent::class,
                    'bookable_id' => $tent->id,
                    'quantity' => $item['quantity'],
                    'price_at_time' => $price,
                ]);
            }
        }

        try {
            // Send email to customer/agency
            Mail::to($booking->customer_email)->send(new BookingReceived($booking));
            
            // Send email to all admins
            $adminEmails = User::pluck('email')->toArray();
            if (!empty($adminEmails)) {
                Mail::to($adminEmails)->send(new NewBookingNotification($booking));
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the request since booking was created
            \Illuminate\Support\Facades\Log::error('Mail sending failed: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }
}
