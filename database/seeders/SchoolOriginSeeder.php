<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolOrigin;
use App\Models\PpdbRegistration;

class SchoolOriginSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = PpdbRegistration::all();
        
        foreach ($registrations as $registration) {
            SchoolOrigin::create([
                'pendaftar_id' => $registration->id,
                'npsn' => '20123456',
                'nama_sekolah' => 'SMP Negeri 1 Jakarta',
                'kabupaten' => 'Jakarta Pusat',
                'nilai_rata' => 85.50
            ]);
        }
    }
}