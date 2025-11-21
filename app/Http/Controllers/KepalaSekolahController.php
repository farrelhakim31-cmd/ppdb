<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbRegistration;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KepalaSekolahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard()
    {
        // KPI Utama
        $kuota = 300; // Target kuota
        $totalPendaftar = PpdbRegistration::count();
        $diterima = PpdbRegistration::where('status', 'terima')->count();
        $pending = PpdbRegistration::where('status', 'pending')->count();
        $ditolak = PpdbRegistration::where('status', 'tolak')->count();
        
        // Rasio vs Kuota
        $rasioKuota = $kuota > 0 ? round(($totalPendaftar / $kuota) * 100, 1) : 0;
        
        // Tren Harian (7 hari terakhir)
        $trenHarian = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trenHarian[] = [
                'tanggal' => $date->format('d/m'),
                'pendaftar' => PpdbRegistration::whereDate('created_at', $date)->count(),
                'terverifikasi' => PpdbRegistration::where('status', '!=', 'pending')
                    ->whereDate('updated_at', $date)->count()
            ];
        }
        
        // Rasio Terverifikasi
        $rasioTerverifikasi = $totalPendaftar > 0 ? 
            round((($diterima + $ditolak) / $totalPendaftar) * 100, 1) : 0;
        
        // Komposisi Asal Sekolah
        $asalSekolah = PpdbRegistration::select('school_origin', DB::raw('count(*) as jumlah'))
            ->whereNotNull('school_origin')
            ->groupBy('school_origin')
            ->orderBy('jumlah', 'desc')
            ->limit(5)
            ->get();
        
        // Komposisi Jurusan
        $komposisiJurusan = PpdbRegistration::select('major', DB::raw('count(*) as jumlah'))
            ->groupBy('major')
            ->orderBy('jumlah', 'desc')
            ->get();
        
        // Status Pembayaran
        $statusPembayaran = [
            'lunas' => PpdbRegistration::where('payment_status', 'paid')->count(),
            'pending' => PpdbRegistration::where('payment_status', 'pending')->count(),
            'belum' => PpdbRegistration::where('payment_status', 'unpaid')->count()
        ];
        
        return view('kepala.dashboard', compact(
            'kuota',
            'totalPendaftar', 
            'diterima',
            'pending',
            'ditolak',
            'rasioKuota',
            'trenHarian',
            'rasioTerverifikasi',
            'asalSekolah',
            'komposisiJurusan',
            'statusPembayaran'
        ));
    }
    
    public function reports(Request $request)
    {
        $query = PpdbRegistration::query();
        
        // Filter berdasarkan periode
        if ($request->filled('period') && $request->period !== 'all') {
            $query->whereDate('created_at', '>=', Carbon::now()->subDays((int)$request->period));
        }
        
        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $registrations = $query->latest()->paginate(10);
        
        return view('kepala.reports', compact('registrations'));
    }
    
    public function exportReport(Request $request)
    {
        $type = $request->get('type', 'excel');
        $period = $request->get('period', 'all');
        
        $query = PpdbRegistration::query();
        
        if ($period !== 'all') {
            $query->whereDate('created_at', '>=', Carbon::now()->subDays((int)$period));
        }
        
        $data = $query->get();
        
        if ($type === 'pdf') {
            return $this->exportToPdf($data);
        }
        
        return $this->exportToExcel($data);
    }
    
    private function exportToExcel($data)
    {
        $filename = 'laporan-ppdb-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No Pendaftaran', 'Nama', 'Email', 'Status', 'Tanggal Daftar']);
            
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->registration_number,
                    $row->name,
                    $row->email,
                    $row->status,
                    $row->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    private function exportToPdf($data)
    {
        // Implementasi export PDF sederhana
        return response()->json(['message' => 'Export PDF akan segera tersedia']);
    }
}