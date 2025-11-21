<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PpdbRegistration;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Services\SystemService;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        $totalIncome = Payment::where('status', 'verified')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $todayPayments = Payment::whereDate('created_at', today())->count();
        $totalStudents = PpdbRegistration::count();
        $recentPayments = Payment::with('student')
            ->latest()
            ->limit(5)
            ->get();
        
        // Ambil notifikasi untuk keuangan
        $notifications = Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->latest()
            ->limit(10)
            ->get();

        return view('keuangan.dashboard', compact(
            'totalIncome',
            'pendingPayments', 
            'todayPayments',
            'totalStudents',
            'recentPayments',
            'notifications'
        ));
    }

    public function ppdb()
    {
        $totalRegistrations = PpdbRegistration::count();
        $paidRegistrations = PpdbRegistration::where('payment_status', 'paid')->count();
        $unpaidRegistrations = PpdbRegistration::where('payment_status', 'unpaid')->count();
        $totalIncome = Payment::where('status', 'verified')
            ->whereHas('ppdbRegistration')
            ->sum('amount');

        $registrations = PpdbRegistration::with('payment')->latest()->paginate(15);

        return view('keuangan.ppdb', compact(
            'totalRegistrations',
            'paidRegistrations',
            'unpaidRegistrations', 
            'totalIncome',
            'registrations'
        ));
    }

    public function ppdbDetail($id)
    {
        $registration = PpdbRegistration::with('payment')->findOrFail($id);
        $payment = $registration->payment;
        
        if (!$payment) {
            abort(404, 'Pembayaran tidak ditemukan');
        }
        
        $payment->load(['ppdbRegistration', 'verifiedBy']);
        
        return view('keuangan.ppdb-detail', compact('payment'));
    }

    public function verifyPayment(Request $request, $id)
    {
        // Hanya keuangan yang bisa memverifikasi pembayaran
        if (auth()->user()->role !== 'keuangan') {
            abort(403, 'Akses ditolak. Hanya bagian keuangan yang dapat memverifikasi pembayaran.');
        }
        
        $registration = PpdbRegistration::findOrFail($id);
        
        $registration->update([
            'payment_status' => 'paid',
            'payment_verified_at' => now(),
            'payment_verified_by' => auth()->id()
        ]);

        // Update payment record jika ada
        if ($registration->payment) {
            $registration->payment->update([
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id()
            ]);
        }
        
        // Kirim notifikasi ke admin bahwa pembayaran sudah diverifikasi
        SystemService::notifyAdmin(
            'Pembayaran PPDB Diverifikasi',
            "Pembayaran untuk pendaftaran {$registration->registration_number} telah diverifikasi dan siap untuk proses selanjutnya",
            'success'
        );
        
        // Log activity
        SystemService::logActivity('payment_verified', $registration, "Payment verified for registration {$registration->registration_number}");

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi. Admin sekarang bisa menerima siswa ini.');
    }

    public function createBill(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'description' => 'required|string'
        ]);

        $registration = PpdbRegistration::findOrFail($id);
        
        // Cari atau buat student
        $student = \App\Models\Student::firstOrCreate(
            ['pendaftar_id' => $registration->id],
            [
                'name' => $registration->full_name ?? $registration->name,
                'email' => $registration->email,
                'nik' => $registration->nik ?? '0000000000000000',
                'nisn' => $registration->nisn ?? '0000000000',
                'nama_ayah' => $registration->parent_name ?? '-',
                'nik_ayah' => $registration->parent_nik ?? '0000000000000000',
                'jk' => $registration->gender ?? 'L',
                'tmp_lahir' => $registration->birth_place ?? '-',
                'tgl_lahir' => $registration->birth_date ?? now(),
                'alamat' => $registration->address ?? '-',
                'wilayah_id' => 1,
                'lat' => 0,
                'lng' => 0,
                'phone' => $registration->phone ?? '0000000000'
            ]
        );

        $bill = \App\Models\Bill::create([
            'student_id' => $student->id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'status' => 'unpaid',
            'created_by' => auth()->id()
        ]);

        if ($request->has('send_email')) {
            try {
                $bill->load('student');
                $emailTo = 'farreltugas16@gmail.com';
                \Mail::to($emailTo)->send(new \App\Mail\BillNotification($bill));
                \Log::info('Email tagihan berhasil dikirim ke: ' . $emailTo);
                return redirect()->back()->with('success', 'Tagihan berhasil dibuat dan email dikirim ke ' . $emailTo);
            } catch (\Exception $e) {
                \Log::error('Gagal kirim email tagihan: ' . $e->getMessage());
                return redirect()->back()->with('warning', 'Tagihan berhasil dibuat tapi email gagal dikirim. Error: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Tagihan berhasil dibuat');
    }

    public function sendBulkPaymentReminder()
    {
        $unpaidRegistrations = PpdbRegistration::with('user')
            ->where('payment_status', 'unpaid')
            ->get();

        if ($unpaidRegistrations->isEmpty()) {
            return back()->with('error', 'Tidak ada pendaftar yang belum bayar');
        }

        $sent = 0;
        $failed = 0;
        $noEmail = 0;

        foreach ($unpaidRegistrations as $registration) {
            try {
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

                $this->sendPaymentReminderEmail($registration->user, $registration);
                $sent++;
                
            } catch (\Exception $e) {
                \Log::error('Gagal kirim email ke ' . ($registration->user->email ?? 'unknown') . ': ' . $e->getMessage());
                $failed++;
            }
        }

        $message = "Email pengingat berhasil dikirim ke {$sent} pendaftar";
        if ($failed > 0) $message .= ", {$failed} gagal";
        if ($noEmail > 0) $message .= ", {$noEmail} tidak memiliki email";

        return back()->with('success', $message);
    }

    private function sendPaymentReminderEmail($user, $registration)
    {
        try {
            if (!$user || !$user->email) {
                throw new \Exception('Email siswa tidak ditemukan');
            }

            $data = [
                'name' => $user->name ?? 'Siswa',
                'registration_number' => $registration->no_pendaftaran ?? $registration->registration_number ?? '-',
                'major' => $registration->major ?? $registration->jurusan_pilihan ?? '-',
                'amount' => 300000,
                'school_name' => 'SMK Bakti Nusantara 666'
            ];
            
            \Mail::send('emails.payment-reminder', $data, function($message) use ($user) {
                $message->to($user->email)
                        ->subject('Pengingat Pembayaran PPDB - SMK Bakti Nusantara 666');
            });
            
            \Log::info('Email pengingat pembayaran berhasil dikirim ke: ' . $user->email . ' (Nama: ' . $user->name . ')');
            return true;
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email ke ' . ($user->email ?? 'unknown') . ': ' . $e->getMessage());
            throw $e;
        }
    }
}