<?php
// app/Http/Controllers/Admin/QrisController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QrisController extends Controller
{
     public function generate(Request $request)
     {
          $validated = $request->validate([
               'payment_data' => 'required|string|max:500'
          ]);

          // Generate QR Code
          $qrCode = QrCode::size(300)
               ->format('png')
               ->generate($validated['payment_data']);

          // Save to file
          $filename = 'qris-' . time() . '.png';
          $path = public_path('uploads/qris/' . $filename);

          file_put_contents($path, $qrCode);

          return response()->json([
               'success' => true,
               'filename' => $filename,
               'path' => asset('uploads/qris/' . $filename)
          ]);
     }
}
