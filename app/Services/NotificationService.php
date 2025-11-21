<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    public static function sendAcceptanceEmail($student, $registration)
    {
        try {
            if (!$student || !$student->email) {
                throw new \Exception('Email siswa tidak ditemukan');
            }

            $data = [
                'name' => $student->name ?? 'Siswa',
                'registration_number' => $registration->no_pendaftaran ?? $registration->registration_number ?? '-',
                'major' => $registration->major ?? $registration->jurusan_pilihan ?? '-',
                'school_name' => 'SMK Bakti Nusantara 666'
            ];
            
            Mail::send('emails.acceptance', $data, function($message) use ($student) {
                $message->to($student->email)
                        ->subject('Selamat! Anda Diterima di SMK Bakti Nusantara 666');
            });
            
            \Log::info('Email berhasil dikirim ke: ' . $student->email . ' (Nama: ' . $student->name . ')');
            return true;
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email ke ' . ($student->email ?? 'unknown') . ': ' . $e->getMessage());
            throw $e;
        }
    }

    public static function sendWhatsAppNotification($phone, $name, $registrationNumber)
    {
        $message = "🎉 Selamat {$name}!\n\n";
        $message .= "Anda telah DITERIMA di SMK Bakti Nusantara 666\n";
        $message .= "No. Pendaftaran: {$registrationNumber}\n\n";
        $message .= "Silakan cek email untuk informasi lebih lanjut.\n\n";
        $message .= "Terima kasih 🙏";

        // Implementasi WhatsApp API (contoh menggunakan service pihak ketiga)
        try {
            Http::post('https://api.whatsapp.com/send', [
                'phone' => $phone,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            \Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
    }

    public static function sendAdminNotification($registration)
    {
        try {
            $data = [
                'student_name' => $registration->name ?? $registration->user->name ?? 'Siswa',
                'registration_number' => $registration->no_pendaftaran ?? $registration->registration_number ?? '-',
                'major' => $registration->major ?? $registration->jurusan_pilihan ?? '-',
                'email' => $registration->email ?? $registration->user->email ?? '-',
                'phone' => $registration->phone ?? $registration->user->phone ?? '-',
                'accepted_at' => now()->format('d/m/Y H:i'),
                'accepted_by' => auth()->user()->name ?? 'Admin'
            ];
            
            Mail::send('emails.admin-notification', $data, function($message) {
                $message->to('farreltugas16@gmail.com')
                        ->subject('Notifikasi Penerimaan Siswa Baru - SMK Bakti Nusantara 666');
            });
            
            \Log::info('Admin notification sent for student: ' . $data['student_name']);
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send admin notification: ' . $e->getMessage());
            throw $e;
        }
    }
}