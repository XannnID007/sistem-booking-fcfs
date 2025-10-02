<?php

// app/Http/Controllers/Customer/HomeController.php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\Booking;

class HomeController extends Controller
{
    public function index()
    {
        $studios = Studio::aktif()->take(6)->get();
        $bookingAktif = Booking::where('user_id', auth()->id())
            ->whereIn('status_booking', ['pending', 'dibayar'])
            ->count();

        return view('customer.home', compact('studios', 'bookingAktif'));
    }
}
