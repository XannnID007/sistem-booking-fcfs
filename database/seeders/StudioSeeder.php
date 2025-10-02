<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Studio;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        $studios = [
            [
                'nama_studio' => 'Studio A - Professional',
                'deskripsi' => 'Studio professional dengan peralatan lengkap. Cocok untuk recording album dan produksi musik berkualitas tinggi. Dilengkapi dengan soundproof room, mixing console, dan berbagai instrumen musik.',
                'lokasi' => 'Jl. Dago No. 123, Bandung',
                'harga_per_jam' => 150000,
                'status' => 'aktif'
            ],
            [
                'nama_studio' => 'Studio B - Standard',
                'deskripsi' => 'Studio dengan fasilitas standard yang nyaman. Cocok untuk latihan band dan recording demo. Ruangan ber-AC dengan akustik yang baik.',
                'lokasi' => 'Jl. Cihampelas No. 45, Bandung',
                'harga_per_jam' => 100000,
                'status' => 'aktif'
            ],
            [
                'nama_studio' => 'Studio C - Basic',
                'deskripsi' => 'Studio basic dengan harga terjangkau. Cocok untuk latihan dan jamming session. Peralatan lengkap untuk band dengan harga ekonomis.',
                'lokasi' => 'Jl. Buah Batu No. 78, Bandung',
                'harga_per_jam' => 75000,
                'status' => 'aktif'
            ],
            [
                'nama_studio' => 'Studio D - Premium',
                'deskripsi' => 'Studio premium dengan acoustik terbaik. Dilengkapi dengan peralatan recording kelas dunia dan engineer berpengalaman. Hasil rekaman berkualitas studio profesional.',
                'lokasi' => 'Jl. Setiabudi No. 200, Bandung',
                'harga_per_jam' => 200000,
                'status' => 'aktif'
            ],
            [
                'nama_studio' => 'Studio E - Rehearsal',
                'deskripsi' => 'Studio khusus untuk rehearsal band. Ruangan luas dengan soundproofing maksimal. Cocok untuk latihan band dengan formasi lengkap.',
                'lokasi' => 'Jl. Dipatiukur No. 56, Bandung',
                'harga_per_jam' => 120000,
                'status' => 'aktif'
            ],
            [
                'nama_studio' => 'Studio F - Recording',
                'deskripsi' => 'Studio recording dengan engineer berpengalaman. Hasil recording berkualitas studio dengan harga terjangkau. Cocok untuk recording lagu, podcast, dan voice over.',
                'lokasi' => 'Jl. Sukajadi No. 89, Bandung',
                'harga_per_jam' => 180000,
                'status' => 'aktif'
            ],
        ];

        foreach ($studios as $studio) {
            Studio::create($studio);
        }
    }
}
