<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrisSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_merchant',
        'nomor_merchant',
        'qr_code_image',
        'status'
    ];

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
