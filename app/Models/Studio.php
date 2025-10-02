<?php

// app/Models/Studio.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_studio',
        'deskripsi',
        'lokasi',
        'harga_per_jam',
        'gambar',
        'status'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
