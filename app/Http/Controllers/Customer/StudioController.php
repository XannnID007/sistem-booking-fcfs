<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Studio;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::aktif()->paginate(12);
        return view('customer.studio.index', compact('studios'));
    }

    public function show(Studio $studio)
    {
        return view('customer.studio.show', compact('studio'));
    }
}
