<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.studio.index', compact('studios'));
    }

    public function create()
    {
        return view('admin.studio.create');
    }

    public function show(Studio $studio)
    {
        // Load relasi bookings dengan user
        $studio->load(['bookings.user']);

        // Hitung statistik
        $totalBooking = $studio->bookings()->count();
        $bookingSelesai = $studio->bookings()->where('status_booking', 'selesai')->count();
        $totalPendapatan = $studio->bookings()
            ->where('status_booking', 'selesai')
            ->sum('total_harga');

        return view('admin.studio.show', compact(
            'studio',
            'totalBooking',
            'bookingSelesai',
            'totalPendapatan'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_studio' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string|max:150',
            'harga_per_jam' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = 'studio_' . time() . '.' . $file->extension();
            $file->move(public_path('uploads/studios'), $filename);
            $validated['gambar'] = $filename;
        }

        Studio::create($validated);

        return redirect()->route('admin.studio.index')->with('success', 'Studio berhasil ditambahkan.');
    }

    public function edit(Studio $studio)
    {
        return view('admin.studio.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
    {
        $validated = $request->validate([
            'nama_studio' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string|max:150',
            'harga_per_jam' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($studio->gambar && file_exists(public_path('uploads/studios/' . $studio->gambar))) {
                unlink(public_path('uploads/studios/' . $studio->gambar));
            }

            $file = $request->file('gambar');
            $filename = 'studio_' . time() . '.' . $file->extension();
            $file->move(public_path('uploads/studios'), $filename);
            $validated['gambar'] = $filename;
        }

        $studio->update($validated);

        return redirect()->route('admin.studio.index')->with('success', 'Studio berhasil diupdate.');
    }

    public function destroy(Studio $studio)
    {
        // Cek apakah ada booking aktif
        $hasActiveBooking = $studio->bookings()
            ->whereIn('status_booking', ['pending', 'dibayar'])
            ->exists();

        if ($hasActiveBooking) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus studio yang memiliki booking aktif.');
        }

        // Hapus gambar
        if ($studio->gambar && file_exists(public_path('uploads/studios/' . $studio->gambar))) {
            unlink(public_path('uploads/studios/' . $studio->gambar));
        }

        $studio->delete();

        return redirect()->route('admin.studio.index')->with('success', 'Studio berhasil dihapus.');
    }
}
