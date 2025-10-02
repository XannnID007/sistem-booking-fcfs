<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'studio_id',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'durasi_jam',
        'total_harga',
        'status_booking',
        'bukti_pembayaran',
        'catatan'
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopePending($query)
    {
        return $query->where('status_booking', 'pending');
    }

    public function scopeDibayar($query)
    {
        return $query->where('status_booking', 'dibayar');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status_booking', 'selesai');
    }
}
