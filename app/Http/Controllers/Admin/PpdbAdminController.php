<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;

class PpdbAdminController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'status' => 'nullable|in:pending,terima,tolak',
                'search' => 'nullable|string|max:255',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date'
            ]);

            $query = PpdbRegistration::query();
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('search')) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('registration_number', 'like', $searchTerm)
                      ->orWhere('email', 'like', $searchTerm);
                });
            }
            
            if ($request->filled('start_date')) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }
            
            if ($request->filled('end_date')) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }
            
            $registrations = $query->latest()->paginate(20);
            
            return view('admin.ppdb.index', compact('registrations'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memuat data.']);
        }
    }
    
    public function exportReport(Request $request)
    {
        $query = PpdbRegistration::query();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $registrations = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'laporan_ppdb_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'No. Pendaftaran', 'Nama', 'Email', 'Jurusan', 'Status', 'Tanggal Daftar']);
            
            foreach ($registrations as $index => $registration) {
                fputcsv($file, [
                    $index + 1,
                    $registration->registration_number,
                    $registration->name,
                    $registration->email,
                    $registration->major,
                    $registration->status,
                    $registration->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportPdf(Request $request)
    {
        $query = PpdbRegistration::query();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $registrations = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.ppdb.report-pdf', compact('registrations'));
    }

    public function show(PpdbRegistration $registration)
    {
        $registration->load(['verifier', 'documents']);
        $verificationLogs = \DB::table('verification_logs')
            ->join('users', 'verification_logs.verifier_id', '=', 'users.id')
            ->where('registration_id', $registration->id)
            ->select('verification_logs.*', 'users.name as verifier_name')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.ppdb.show', compact('registration', 'verificationLogs'));
    }

    public function verify(Request $request, PpdbRegistration $registration)
    {
        // Hanya admin yang bisa memverifikasi siswa
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat memverifikasi siswa.');
        }

        $request->validate([
            'verification_status' => 'required|in:lulus,tolak,perbaikan',
            'verification_notes' => 'required|string|max:500'
        ]);

        // Jika status lulus, validasi pembayaran harus sudah dikonfirmasi
        if ($request->verification_status === 'lulus' && $registration->payment_status !== 'paid') {
            return back()->withErrors(['error' => 'Tidak dapat menerima siswa. Pembayaran belum dikonfirmasi oleh bagian keuangan.']);
        }

        $status = $request->verification_status === 'lulus' ? 'terima' : 
                 ($request->verification_status === 'tolak' ? 'tolak' : 'pending');

        $registration->update([
            'status' => $status,
            'verification_status' => $request->verification_status,
            'verification_notes' => $request->verification_notes,
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);

        // Log verifikasi
        \DB::table('verification_logs')->insert([
            'registration_id' => $registration->id,
            'verifier_id' => auth()->id(),
            'status' => $request->verification_status,
            'notes' => $request->verification_notes,
            'created_at' => now()
        ]);

        return back()->with('success', 'Verifikasi berhasil disimpan');
    }

    public function accept(PpdbRegistration $registration)
    {
        // Hanya admin yang bisa menerima siswa
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat menerima siswa.');
        }

        // Validasi pembayaran harus sudah dikonfirmasi keuangan
        if ($registration->payment_status !== 'paid') {
            return back()->withErrors(['error' => 'Siswa tidak dapat diterima. Pembayaran belum dikonfirmasi oleh bagian keuangan.']);
        }

        $registration->update([
            'status' => 'terima',
            'verification_status' => 'lulus',
            'accepted_at' => now(),
            'accepted_by' => auth()->id()
        ]);
        
        return back()->with('success', 'Pendaftar berhasil diterima');
    }

    public function reject(PpdbRegistration $registration)
    {
        // Hanya admin yang bisa menolak siswa
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat menolak siswa.');
        }

        $registration->update(['status' => 'tolak']);
        return back()->with('success', 'Pendaftar ditolak');
    }

    public function destroy(PpdbRegistration $registration)
    {
        // Hanya admin yang bisa menghapus data siswa
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat menghapus data siswa.');
        }

        $registration->documents()->delete();
        $registration->payment()->delete();
        
        if ($registration->user) {
            $registration->user->delete();
        }
        
        $registration->delete();
        
        return redirect()->route('admin.ppdb.index')->with('success', 'Data siswa dan akun berhasil dihapus');
    }



    public function checkRequirements(PpdbRegistration $registration)
    {
        $registration->load(['documents', 'payment']);
        
        $documentsCount = $registration->documents()->count();
        
        $requirements = [
            'data_lengkap' => [
                'label' => 'Data Pribadi Lengkap',
                'status' => !empty($registration->name) && !empty($registration->email) && !empty($registration->phone) && !empty($registration->birth_date) && !empty($registration->birth_place) && !empty($registration->gender) && !empty($registration->address)
            ],
            'data_ortu' => [
                'label' => 'Data Orang Tua Lengkap', 
                'status' => !empty($registration->parent_name) && !empty($registration->parent_phone) && !empty($registration->parent_job)
            ],
            'asal_sekolah' => [
                'label' => 'Asal Sekolah Terisi',
                'status' => !empty($registration->school_origin)
            ],
            'umur_minimal' => [
                'label' => 'Umur Minimal 15 Tahun',
                'status' => $registration->birth_date ? $registration->birth_date->diffInYears(now()) >= 15 : false
            ],
            'dokumen_lengkap' => [
                'label' => 'Dokumen Pendukung Lengkap (Min. 3)',
                'status' => $documentsCount >= 3
            ],
            'pembayaran' => [
                'label' => 'Status Pembayaran',
                'status' => $registration->payment_status === 'paid'
            ]
        ];
        
        $totalRequirements = count($requirements);
        $completedRequirements = collect($requirements)->where('status', true)->count();
        $completionPercentage = $totalRequirements > 0 ? round(($completedRequirements / $totalRequirements) * 100) : 0;
        
        return view('admin.ppdb.requirements', compact('registration', 'requirements', 'completionPercentage'));
    }

    public function validateDocument($documentId)
    {
        $document = \App\Models\RegistrationDocument::findOrFail($documentId);
        $document->update(['valid' => true]);
        
        return back()->with('success', 'Dokumen berhasil divalidasi');
    }

    public function dashboard()
    {
        try {
            // Optimize queries by using single query with selectRaw
            $stats = PpdbRegistration::selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "terima" THEN 1 ELSE 0 END) as terima,
                SUM(CASE WHEN status = "tolak" THEN 1 ELSE 0 END) as tolak
            ')->first();

            $recentRegistrations = PpdbRegistration::latest()->limit(10)->get();
            
            return view('admin.dashboard', compact('stats', 'recentRegistrations'));
        } catch (\Exception $e) {
            return view('admin.dashboard')->withErrors(['error' => 'Terjadi kesalahan saat memuat dashboard.']);
        }
    }
}