<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $trips = \App\Models\Trip::where('is_active', true)->get();
        return view('booking', compact('trips'));
    }

    public function success($code)
    {
        $booking = \App\Models\Booking::with('trip')->where('booking_code', $code)->firstOrFail();
        return view('booking-success', compact('booking'));
    }
}
