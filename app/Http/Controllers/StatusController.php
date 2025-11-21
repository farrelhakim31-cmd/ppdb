<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbRegistration;

class StatusController extends Controller
{
    public function index()
    {
        return view('status.check');
    }

    public function check(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string'
        ]);

        $registration = PpdbRegistration::where('registration_number', $request->registration_number)
            ->orWhere('no_pendaftaran', $request->registration_number)
            ->with(['payment', 'documents'])
            ->first();

        if (!$registration) {
            return back()->with('error', 'Nomor pendaftaran tidak ditemukan.');
        }

        return redirect()->route('siswa.status');
    }
}