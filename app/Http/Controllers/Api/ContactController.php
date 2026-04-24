<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageReceived;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Get all admin emails
            $adminEmails = User::pluck('email')->toArray();
            
            if (!empty($adminEmails)) {
                Mail::to($adminEmails)->send(new ContactMessageReceived($validated));
            }

            return response()->json([
                'message' => 'Your message has been sent successfully. We will get back to you soon.',
            ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Contact form failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to send message. Please try again later.',
            ], 500);
        }
    }
}
