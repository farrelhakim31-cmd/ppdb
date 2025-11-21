<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbRegistration;
use App\Models\RegistrationDocument;
use App\Models\AuditLog;
use App\Models\Notification;
use App\Jobs\SendNotificationJob;
use Illuminate\Support\Facades\Auth;

class VerifikatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:verifikator']);
    }

    public function dashboard()
    {
        $pendingVerification = PpdbRegistration::where('status', 'pending')->count();
        $verifiedToday = PpdbRegistration::whereIn('status', ['terima', 'tolak'])
            ->whereDate('updated_at', today())->count();
        $totalProcessed = PpdbRegistration::whereIn('status', ['terima', 'tolak'])->count();
        
        $recentRegistrations = PpdbRegistration::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('verifikator.dashboard', compact(
            'pendingVerification',
            'verifiedToday', 
            'totalProcessed',
            'recentRegistrations'
        ));
    }

    public function index(Request $request)
    {
        $query = PpdbRegistration::query();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('registration_number', 'like', '%' . $request->search . '%');
            });
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('verifikator.index', compact('registrations'));
    }

    public function show($id)
    {
        $registration = PpdbRegistration::with('documents')->findOrFail($id);
        return view('verifikator.show', compact('registration'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terima,tolak,perbaikan',
            'notes' => 'nullable|string|max:500'
        ]);

        $registration = PpdbRegistration::findOrFail($id);
        
        $registration->update([
            'status' => $request->status,
            'verification_notes' => $request->notes,
            'verified_by' => Auth::id(),
            'verified_at' => now()
        ]);

        // Log audit
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'verify_registration',
            'description' => "Verifikasi pendaftaran {$registration->name} dengan status {$request->status}",
            'ip_address' => $request->ip()
        ]);
        
        // Kirim notifikasi ke pendaftar menggunakan job
        SendNotificationJob::dispatch($registration->id, 'verification_result', [
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('verifikator.index')
            ->with('success', 'Verifikasi berhasil disimpan');
    }

    public function validateDocument(Request $request, $documentId)
    {
        $request->validate([
            'status' => 'required|in:valid,invalid',
            'notes' => 'nullable|string|max:255'
        ]);

        $document = RegistrationDocument::findOrFail($documentId);
        
        $document->update([
            'validation_status' => $request->status,
            'validation_notes' => $request->notes,
            'validated_by' => Auth::id(),
            'validated_at' => now()
        ]);

        return response()->json(['success' => true]);
    }
    
    private function sendVerificationNotification($registration, $status, $notes = null)
    {
        $statusText = [
            'terima' => 'DITERIMA',
            'tolak' => 'DITOLAK', 
            'perbaikan' => 'PERLU PERBAIKAN'
        ];
        
        $message = "Pendaftaran PPDB Anda telah {$statusText[$status]}.";
        if ($notes) {
            $message .= " Catatan: {$notes}";
        }
        
        // Simpan notifikasi ke database
        Notification::create([
            'user_id' => $registration->user_id,
            'title' => 'Status Verifikasi PPDB',
            'message' => $message,
            'type' => 'verification_result',
            'is_read' => false
        ]);
        
        // TODO: Implementasi kirim email/SMS/WhatsApp
        // $this->sendEmail($registration->email, $message);
        // $this->sendSMS($registration->phone, $message);
    }
}