<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Gelombang;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        $jurusan = [
            ['kode' => 'PPLG', 'nama' => 'PPLG', 'kuota' => 36, 'is_active' => true],
            ['kode' => 'AKL', 'nama' => 'Akuntansi', 'kuota' => 36, 'is_active' => true],
            ['kode' => 'ANM', 'nama' => 'Animasi', 'kuota' => 36, 'is_active' => true],
            ['kode' => 'DKV', 'nama' => 'DKV', 'kuota' => 36, 'is_active' => true],
            ['kode' => 'BDP', 'nama' => 'BDP', 'kuota' => 36, 'is_active' => true],
        ];
        foreach ($jurusan as $j) Jurusan::updateOrCreate(['kode' => $j['kode']], $j);

        $gelombang = [
            ['nama' => 'Gelombang 1', 'tanggal_mulai' => '2024-01-01', 'tanggal_selesai' => '2024-03-31', 'biaya_pendaftaran' => 150000, 'is_active' => true],
            ['nama' => 'Gelombang 2', 'tanggal_mulai' => '2024-04-01', 'tanggal_selesai' => '2024-06-30', 'biaya_pendaftaran' => 200000, 'is_active' => false],
        ];
        foreach ($gelombang as $g) Gelombang::updateOrCreate(['nama' => $g['nama']], $g);

        // Sample data untuk fitur tambahan
        \App\Models\JenisPembayaran::updateOrCreate(['nama' => 'Biaya Pendaftaran'], ['nominal' => 150000, 'is_active' => true]);
        \App\Models\JenisPembayaran::updateOrCreate(['nama' => 'Biaya Daftar Ulang'], ['nominal' => 500000, 'is_active' => true]);
        
        \App\Models\JenisDokumen::updateOrCreate(['nama' => 'Ijazah SMP'], ['is_required' => true, 'is_active' => true]);
        \App\Models\JenisDokumen::updateOrCreate(['nama' => 'Kartu Keluarga'], ['is_required' => true, 'is_active' => true]);
        \App\Models\JenisDokumen::updateOrCreate(['nama' => 'Pas Foto'], ['is_required' => true, 'is_active' => true]);
        
        \App\Models\Provinsi::updateOrCreate(['kode' => '40391'], ['nama' => 'Cileunyi']);
        \App\Models\Provinsi::updateOrCreate(['kode' => '40115'], ['nama' => 'Bandung Kota']);
        \App\Models\Provinsi::updateOrCreate(['kode' => '40371'], ['nama' => 'Bandung Barat']);
    }
}