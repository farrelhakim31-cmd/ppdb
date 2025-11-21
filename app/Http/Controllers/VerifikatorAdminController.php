<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbRegistration;
use App\Models\VerificationLog;
use Illuminate\Support\Facades\Auth;

class VerifikatorAdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total' => PpdbRegistration::count(),
            'pending' => PpdbRegistration::where('verification_status', 'pending')->count(),
            'approved' => PpdbRegistration::where('verification_status', 'approved')->count(),
            'rejected' => PpdbRegistration::where('verification_status', 'rejected')->count(),
            'revision' => PpdbRegistration::where('verification_status', 'revision')->count(),
        ];

        $recent_verifications = VerificationLog::with(['registration', 'verifier'])
            ->latest()
            ->take(10)
            ->get();

        return view('verifikator-admin.dashboard', compact('stats', 'recent_verifications'));
    }

    public function index(Request $request)
    {
        $query = PpdbRegistration::with(['user', 'parentData', 'schoolOrigin']);

        if ($request->status) {
            $query->where('verification_status', $request->status);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('no_pendaftaran', 'like', '%' . $request->search . '%')
                  ->orWhere('registration_number', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('verifikator-admin.index', compact('registrations'));
    }

    public function show($id)
    {
        $registration = PpdbRegistration::with(['user', 'parentData', 'schoolOrigin', 'documents'])
            ->findOrFail($id);

        $verification_logs = VerificationLog::where('ppdb_registration_id', $id)
            ->with('verifier')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('verifikator-admin.show', compact('registration', 'verification_logs'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,revision',
            'notes' => 'required|string|max:1000'
        ]);

        $registration = PpdbRegistration::findOrFail($id);
        
        $registration->update([
            'verification_status' => $request->status,
            'verification_notes' => $request->notes,
            'verified_at' => now(),
            'verified_by' => Auth::id()
        ]);

        // Log verifikasi
        VerificationLog::create([
            'ppdb_registration_id' => $id,
            'verifier_id' => Auth::id(),
            'status' => $request->status,
            'notes' => $request->notes,
            'verified_at' => now()
        ]);

        $statusText = [
            'approved' => 'disetujui',
            'rejected' => 'ditolak', 
            'revision' => 'perlu perbaikan'
        ];

        return redirect()->back()->with('success', 
            "Pendaftaran berhasil {$statusText[$request->status]}.");
    }
}