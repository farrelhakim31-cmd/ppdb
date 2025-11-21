<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbRegistration;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function notifyStudent(Request $request, $registrationId)
    {
        $registration = PpdbRegistration::findOrFail($registrationId);
        
        $message = $request->input('message', 'Silakan periksa dokumen pendaftaran Anda dan upload ulang jika diperlukan.');
        
        Notification::create([
            'user_id' => $registration->user_id,
            'title' => 'Pemberitahuan Dokumen PPDB',
            'message' => $message,
            'type' => 'document_issue',
            'is_read' => false
        ]);
        
        return response()->json(['success' => true, 'message' => 'Notifikasi berhasil dikirim ke siswa']);
    }
    
    public function requestReupload(Request $request, $registrationId)
    {
        $registration = PpdbRegistration::findOrFail($registrationId);
        
        $message = 'Dokumen Anda perlu diupload ulang. Silakan login ke dashboard dan upload dokumen yang valid.';
        
        Notification::create([
            'user_id' => $registration->user_id,
            'title' => 'Permintaan Upload Ulang Dokumen',
            'message' => $message,
            'type' => 'reupload_request',
            'is_read' => false
        ]);
        
        return response()->json(['success' => true, 'message' => 'Permintaan upload ulang berhasil dikirim']);
    }
}