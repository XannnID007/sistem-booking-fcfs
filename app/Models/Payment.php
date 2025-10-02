<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'jumlah_bayar',
        'tipe_pembayaran',
        'metode_pembayaran',
        'status_pembayaran',
        'bukti_transfer',
        'catatan_admin',
        'tanggal_verifikasi',
        'verifikasi_oleh'
    ];

    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikasi_oleh');
    }

    public function scopePending($query)
    {
        return $query->where('status_pembayaran', 'pending');
    }

    public function scopeTerverifikasi($query)
    {
        return $query->where('status_pembayaran', 'terverifikasi');
    }
}
