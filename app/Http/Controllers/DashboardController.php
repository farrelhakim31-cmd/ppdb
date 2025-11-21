<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function siswa()
    {
        try {
            $registration = PpdbRegistration::where('user_id', Auth::id())
                ->with(['payment', 'documents'])
                ->first();
                
            $progressPercentage = $registration ? $this->getProgressPercentage($registration->status) : 0;
                
            return view('dashboard.siswa', compact('registration', 'progressPercentage'));
        } catch (\Exception $e) {
            return view('dashboard.siswa')->withErrors(['error' => 'Terjadi kesalahan saat memuat dashboard.']);
        }
    }
    
    public function siswaStatus()
    {
        try {
            $registration = PpdbRegistration::where('user_id', Auth::id())
                ->with(['payment', 'documents'])
                ->first();
                
            if (!$registration) {
                return redirect()->route('siswa.dashboard')
                    ->with('error', 'Data pendaftaran tidak ditemukan.');
            }
            
            // Cek kelengkapan dokumen
            $requiredDocs = [
                'kartu_keluarga' => 'Fotokopi Kartu Keluarga',
                'akta_kelahiran' => 'Fotokopi Akta Kelahiran', 
                'ijazah' => 'Fotokopi Ijazah/SKHUN',
                'pas_foto' => 'Pas foto 3x4 (2 lembar)',
                'surat_sehat' => 'Surat keterangan sehat'
            ];
            
            $uploadedDocs = $registration->documents()->pluck('jenis')->toArray();
            $missingDocs = array_diff(array_keys($requiredDocs), $uploadedDocs);
            
            return view('student.status', compact('registration', 'requiredDocs', 'missingDocs'));
        } catch (\Exception $e) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Terjadi kesalahan saat memuat status pendaftaran.');
        }
    }
    
    private function getProgressPercentage($status)
    {
        $statusMap = [
            'pending' => 25,
            'verified' => 75,
            'accepted' => 100,
            'rejected' => 0
        ];
        
        return $statusMap[$status] ?? 0;
    }
    
    public function getValidationStatus($registration)
    {
        $validationStatus = [
            'data_pribadi' => [
                'status' => !empty($registration->name) && !empty($registration->email) && !empty($registration->phone),
                'label' => 'Data Pribadi',
                'description' => 'Informasi personal lengkap'
            ],
            'dokumen' => [
                'status' => $registration->documents()->count() >= 5,
                'label' => 'Dokumen Persyaratan', 
                'description' => 'Upload semua dokumen yang diperlukan'
            ],
            'pembayaran' => [
                'status' => $registration->payment_status === 'paid',
                'label' => 'Pembayaran',
                'description' => 'Biaya pendaftaran sudah lunas'
            ],
            'verifikasi_admin' => [
                'status' => in_array($registration->status, ['verified', 'accepted']),
                'label' => 'Verifikasi Admin',
                'description' => 'Validasi oleh admin sekolah'
            ]
        ];
        
        $completedCount = collect($validationStatus)->where('status', true)->count();
        $totalCount = count($validationStatus);
        
        return [
            'items' => $validationStatus,
            'completed' => $completedCount,
            'total' => $totalCount,
            'percentage' => $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0
        ];
    }

    public function admin()
    {
        try {
            return view('dashboard.admin');
        } catch (\Exception $e) {
            return view('dashboard.admin')->withErrors(['error' => 'Terjadi kesalahan saat memuat dashboard.']);
        }
    }

    public function kepala()
    {
        try {
            return view('dashboard.kepala');
        } catch (\Exception $e) {
            return view('dashboard.kepala')->withErrors(['error' => 'Terjadi kesalahan saat memuat dashboard.']);
        }
    }

    public function keuangan()
    {
        try {
            $totalIncome = 0;
            $pendingPayments = 0;
            $todayPayments = 0;
            $totalStudents = PpdbRegistration::count();
            $recentPayments = [];

            return view('dashboard.keuangan', compact(
                'totalIncome',
                'pendingPayments',
                'todayPayments', 
                'totalStudents',
                'recentPayments'
            ));
        } catch (\Exception $e) {
            return view('dashboard.keuangan')->withErrors(['error' => 'Terjadi kesalahan saat memuat dashboard.']);
        }
    }
}