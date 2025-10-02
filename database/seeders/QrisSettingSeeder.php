<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QrisSetting;

class QrisSettingSeeder extends Seeder
{
    public function run(): void
    {
        QrisSetting::create([
            'nama_merchant' => 'Studio Musik Booking',
            'nomor_merchant' => '1234567',
            'qr_code_image' => 'qris-default.png',
            'status' => 'aktif'
        ]);
    }
}
