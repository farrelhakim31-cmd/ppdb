<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\InfoPpdb;

class InfoPpdbSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama_sekolah' => 'SMK Bakti Nusantara 666',
            'alamat_sekolah' => 'Jl. Raya Cileunyi, Bandung, Jawa Barat',
            'telepon_sekolah' => '022-87654321',
            'email_sekolah' => 'info@smkbaktinusantara666.sch.id',
            'tahun_ajaran' => '2024/2025',
            'kepala_sekolah' => 'Drs. Bambang Sutrisno, M.Pd',
        ];
        
        foreach ($data as $key => $value) {
            InfoPpdb::setValue($key, $value);
        }
    }
}