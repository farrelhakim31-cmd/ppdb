<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParentData;
use App\Models\PpdbRegistration;

class ParentDataSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = PpdbRegistration::all();
        
        foreach ($registrations as $registration) {
            ParentData::create([
                'pendaftar_id' => $registration->id,
                'nama_ayah' => 'Budi Santoso',
                'pekerjaan_ayah' => 'Wiraswasta',
                'hp_ayah' => '081234567890',
                'nama_ibu' => 'Siti Nurhaliza',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'hp_ibu' => '081234567891',
                'wali_nama' => null,
                'wali_hp' => null
            ]);
        }
    }
}