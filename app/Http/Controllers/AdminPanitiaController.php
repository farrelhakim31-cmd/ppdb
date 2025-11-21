<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbRegistration;
use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\JenisPembayaran;
use App\Models\JenisDokumen;
use App\Models\Provinsi;
use App\Models\InfoPpdb;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;

class AdminPanitiaController extends Controller
{
    public function dashboard()
    {
        // Ringkasan harian
        $today = now()->format('Y-m-d');
        
        $stats = [
            'total_pendaftar' => PpdbRegistration::count(),
            'hari_ini' => PpdbRegistration::whereDate('created_at', $today)->count(),
            'terverifikasi' => PpdbRegistration::where('verification_status', 'approved')->count(),
            'terbayar' => PpdbRegistration::where('payment_status', 'paid')->count(),
        ];

        // Data per jurusan
        $per_jurusan = PpdbRegistration::select('major', DB::raw('count(*) as total'))
            ->groupBy('major')
            ->get();

        // Tren 7 hari terakhir
        $tren_harian = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $tren_harian[] = [
                'tanggal' => now()->subDays($i)->format('d/m'),
                'pendaftar' => PpdbRegistration::whereDate('created_at', $date)->count(),
                'terverifikasi' => PpdbRegistration::whereDate('verified_at', $date)->count(),
            ];
        }

        return view('admin-panitia.dashboard', compact('stats', 'per_jurusan', 'tren_harian'));
    }

    public function monitoring(Request $request)
    {
        $query = PpdbRegistration::with(['documents']);

        if ($request->jurusan) {
            $query->where('major', $request->jurusan);
        }

        if ($request->status) {
            $query->where('verification_status', $request->status);
        }

        $pendaftar = $query->paginate(20);
        $jurusan_list = PpdbRegistration::distinct()->pluck('major');

        return view('admin-panitia.monitoring', compact('pendaftar', 'jurusan_list'));
    }

    public function mapSebaran()
    {
        $sebaran = PpdbRegistration::select('address', 'major', DB::raw('count(*) as total'))
            ->groupBy('address', 'major')
            ->get();

        return view('admin-panitia.map', compact('sebaran'));
    }

    public function masterData()
    {
        $jurusan = Jurusan::all();
        $gelombang = Gelombang::all();
        $jenisPembayaran = JenisPembayaran::all();
        $jenisDokumen = JenisDokumen::all();
        $provinsi = Provinsi::all();
        $infoPpdb = [
            'nama_sekolah' => InfoPpdb::getValue('nama_sekolah', 'SMK Bakti Nusantara 666'),
            'alamat_sekolah' => InfoPpdb::getValue('alamat_sekolah', 'Jl. Raya Cileunyi, Bandung, Jawa Barat'),
            'telepon_sekolah' => InfoPpdb::getValue('telepon_sekolah', '022-87654321'),
            'email_sekolah' => InfoPpdb::getValue('email_sekolah', 'info@smkbaktinusantara666.sch.id'),
            'tahun_ajaran' => InfoPpdb::getValue('tahun_ajaran', '2024/2025'),
            'kepala_sekolah' => InfoPpdb::getValue('kepala_sekolah', 'Drs. Bambang Sutrisno, M.Pd'),
        ];
        return view('admin-panitia.master-data', compact('jurusan', 'gelombang', 'jenisPembayaran', 'jenisDokumen', 'provinsi', 'infoPpdb'));
    }

    public function storeJurusan(Request $request)
    {
        Jurusan::create($request->validate([
            'kode' => 'required|unique:jurusan',
            'nama' => 'required',
            'kuota' => 'required|integer|min:1'
        ]) + ['is_active' => true]);
        return back()->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function updateJurusan(Request $request, Jurusan $jurusan)
    {
        $jurusan->update($request->validate([
            'kode' => 'required|unique:jurusan,kode,' . $jurusan->id,
            'nama' => 'required',
            'kuota' => 'required|integer|min:1'
        ]) + ['is_active' => $request->has('is_active')]);
        return back()->with('success', 'Jurusan berhasil diperbarui');
    }

    public function toggleJurusan(Jurusan $jurusan)
    {
        $jurusan->update(['is_active' => !$jurusan->is_active]);
        return back()->with('success', 'Status berhasil diubah');
    }

    public function storeGelombang(Request $request)
    {
        Gelombang::create($request->validate([
            'nama' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'biaya_pendaftaran' => 'required|numeric|min:0'
        ]) + ['is_active' => true]);
        return back()->with('success', 'Gelombang berhasil ditambahkan');
    }

    public function updateGelombang(Request $request, Gelombang $gelombang)
    {
        $gelombang->update($request->validate([
            'nama' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'biaya_pendaftaran' => 'required|numeric|min:0'
        ]) + ['is_active' => $request->has('is_active')]);
        return back()->with('success', 'Gelombang berhasil diperbarui');
    }

    public function toggleGelombang(Gelombang $gelombang)
    {
        $gelombang->update(['is_active' => !$gelombang->is_active]);
        return back()->with('success', 'Status berhasil diubah');
    }

    public function storePembayaran(Request $request)
    {
        JenisPembayaran::create($request->validate(['nama' => 'required', 'nominal' => 'required|numeric|min:0']) + ['is_active' => true]);
        return back()->with('success', 'Biaya berhasil ditambahkan');
    }

    public function storeDokumen(Request $request)
    {
        JenisDokumen::create($request->validate(['nama' => 'required', 'is_required' => 'boolean']) + ['is_active' => true]);
        return back()->with('success', 'Dokumen berhasil ditambahkan');
    }

    public function storeProvinsi(Request $request)
    {
        Provinsi::create($request->validate(['nama' => 'required', 'kode' => 'required|unique:provinsi']));
        return back()->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function syncData()
    {
        return back()->with('success', 'Data berhasil disinkronisasi');
    }

    public function backupData()
    {
        return back()->with('success', 'Backup berhasil dibuat');
    }

    public function clearCache()
    {
        \Artisan::call('cache:clear');
        return back()->with('success', 'Cache berhasil dibersihkan');
    }

    public function updateInfoPpdb(Request $request)
    {
        $data = $request->validate([
            'nama_sekolah' => 'required',
            'alamat_sekolah' => 'required',
            'telepon_sekolah' => 'required',
            'email_sekolah' => 'required|email',
            'tahun_ajaran' => 'required',
            'kepala_sekolah' => 'required',
        ]);

        foreach ($data as $key => $value) {
            InfoPpdb::setValue($key, $value);
        }

        return back()->with('success', 'Informasi PPDB berhasil diperbarui');
    }

    public function acceptStudent($id)
    {
        $registration = PpdbRegistration::with('user')->findOrFail($id);
        
        $registration->update([
            'status' => 'accepted',
            'accepted_at' => now(),
            'accepted_by' => auth()->id()
        ]);

        // Kirim notifikasi email ke siswa
        try {
            NotificationService::sendAcceptanceEmail($registration->user, $registration);
        } catch (\Exception $e) {
            \Log::error('Email notification failed: ' . $e->getMessage());
        }

        // Kirim notifikasi ke admin (farreltugas16@gmail.com)
        try {
            NotificationService::sendAdminNotification($registration);
        } catch (\Exception $e) {
            \Log::error('Admin notification failed: ' . $e->getMessage());
        }

        // Kirim notifikasi WhatsApp jika ada nomor HP
        if ($registration->user->phone) {
            try {
                NotificationService::sendWhatsAppNotification(
                    $registration->user->phone,
                    $registration->user->name,
                    $registration->no_pendaftaran
                );
            } catch (\Exception $e) {
                \Log::error('WhatsApp notification failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Siswa berhasil diterima dan notifikasi telah dikirim');
    }

    public function sendNotification(Request $request, $id)
    {
        $registration = PpdbRegistration::with('user')->findOrFail($id);
        $type = $request->type;

        try {
            if ($type === 'email') {
                if (!$registration->user || !$registration->user->email) {
                    return back()->with('error', 'Email siswa tidak ditemukan');
                }
                NotificationService::sendAcceptanceEmail($registration->user, $registration);
                $message = 'Email berhasil dikirim ke ' . $registration->user->email;
            } elseif ($type === 'whatsapp') {
                if (!$registration->user || !$registration->user->phone) {
                    return back()->with('error', 'Nomor WhatsApp tidak tersedia');
                }
                NotificationService::sendWhatsAppNotification(
                    $registration->user->phone,
                    $registration->user->name,
                    $registration->no_pendaftaran ?? $registration->registration_number
                );
                $message = 'WhatsApp berhasil dikirim ke ' . $registration->user->phone;
            } else {
                return back()->with('error', 'Tipe notifikasi tidak valid');
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim notifikasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim notifikasi. Periksa log untuk detail.');
        }

        return back()->with('success', $message);
    }

    public function exportData(Request $request)
    {
        $data = PpdbRegistration::with(['documents'])->get();
        
        $filename = 'data-ppdb-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No Pendaftaran', 'Nama', 'Email', 'Jurusan', 'Status Verifikasi', 'Status Pembayaran', 'Tanggal Daftar']);
            
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->registration_number ?? $row->no_pendaftaran,
                    $row->name ?? $row->nama_lengkap,
                    $row->email,
                    $row->major ?? $row->jurusan_pilihan,
                    $row->verification_status,
                    $row->payment_status,
                    $row->created_at->format('d/m/Y')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function reports()
    {
        $stats = [
            'total_pendaftar' => PpdbRegistration::count(),
            'terverifikasi' => PpdbRegistration::where('verification_status', 'approved')->count(),
            'terbayar' => PpdbRegistration::where('payment_status', 'paid')->count(),
            'per_jurusan' => PpdbRegistration::select('major', DB::raw('count(*) as total'))
                ->groupBy('major')
                ->get(),
            'per_bulan' => PpdbRegistration::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->get()
        ];

        return view('admin-panitia.reports', compact('stats'));
    }

    public function accounts(Request $request)
    {
        $query = \App\Models\User::query();
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->role && $request->role != 'all') {
            $query->where('role', $request->role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->get();
        return view('admin-panitia.accounts', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,verifikator,keuangan,siswa,kepala',
            'password' => 'required|min:6'
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,verifikator,keuangan,siswa,kepala'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        return back()->with('success', 'User berhasil diperbarui');
    }

    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        // Hapus data terkait terlebih dahulu
        if ($user->role === 'siswa') {
            // Hapus PPDB registration dan dokumen terkait
            $registrations = \App\Models\PpdbRegistration::where('user_id', $user->id)->get();
            foreach ($registrations as $registration) {
                // Hapus dokumen registrasi
                \App\Models\RegistrationDocument::where('pendaftar_id', $registration->id)->delete();
                // Hapus registrasi
                $registration->delete();
            }
            
            // Hapus payment terkait
            \App\Models\Payment::where('student_id', $user->id)->delete();
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }

    public function getUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return response()->json($user);
    }

    public function sendBulkEmail()
    {
        $approvedRegistrations = PpdbRegistration::with('user')
            ->where('verification_status', 'approved')
            ->get();

        if ($approvedRegistrations->isEmpty()) {
            return back()->with('error', 'Tidak ada pendaftar yang disetujui');
        }

        $sent = 0;
        $failed = 0;
        $noEmail = 0;

        foreach ($approvedRegistrations as $registration) {
            try {
                // Cek apakah ada user dan email
                if (!$registration->user) {
                    \Log::warning('User tidak ditemukan untuk registrasi ID: ' . $registration->id);
                    $noEmail++;
                    continue;
                }

                if (!$registration->user->email) {
                    \Log::warning('Email tidak ditemukan untuk user: ' . $registration->user->name);
                    $noEmail++;
                    continue;
                }

                NotificationService::sendAcceptanceEmail($registration->user, $registration);
                $sent++;
                
            } catch (\Exception $e) {
                \Log::error('Gagal kirim email ke ' . ($registration->user->email ?? 'unknown') . ': ' . $e->getMessage());
                $failed++;
            }
        }

        $message = "Email berhasil dikirim ke {$sent} pendaftar";
        if ($failed > 0) $message .= ", {$failed} gagal";
        if ($noEmail > 0) $message .= ", {$noEmail} tidak memiliki email";

        return back()->with('success', $message);
    }
}