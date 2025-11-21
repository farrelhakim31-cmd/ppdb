<?php

namespace App\Http\Controllers;

use App\Models\PpdbRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\SystemService;
use App\Models\RegistrationDocument;
use App\Models\MapSetting;

class PpdbController extends Controller
{
    public function index()
    {
        $mapSettings = MapSetting::getSettings();
        return view('ppdb.index', compact('mapSettings'));
    }

    public function create()
    {
        return $this->register();
    }

    public function register()
    {
        $jurusanList = \App\Models\Jurusan::where('is_active', true)->get();
        return view('ppdb.register', compact('jurusanList'));
    }

    public function store(Request $request)
    {
        try {
            $activeJurusan = \App\Models\Jurusan::where('is_active', true)->pluck('nama')->toArray();
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|email',
                'phone' => 'required|string|max:20|regex:/^[0-9+\-\s]+$/',
                'birth_date' => 'required|date|before:today',
                'birth_place' => 'required|string|max:255',
                'gender' => 'required|in:L,P',
                'address' => 'required|string|min:10',
                'school_origin' => 'required|string|max:255',
                'major' => 'required|in:' . implode(',', $activeJurusan),
                'parent_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'parent_phone' => 'required|string|max:20|regex:/^[0-9+\-\s]+$/',
                'parent_job' => 'required|string|max:255',
                'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ], [
                'name.regex' => 'Nama hanya boleh berisi huruf dan spasi',
                'phone.regex' => 'Format nomor telepon tidak valid',
                'birth_date.before' => 'Tanggal lahir harus sebelum hari ini',
                'address.min' => 'Alamat minimal 10 karakter',
                'major.required' => 'Pilihan jurusan wajib dipilih',
                'major.in' => 'Pilihan jurusan tidak valid',
                'parent_name.regex' => 'Nama orang tua hanya boleh berisi huruf dan spasi',
                'parent_phone.regex' => 'Format nomor telepon orang tua tidak valid',
                'documents.*.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG',
                'documents.*.max' => 'Ukuran file maksimal 2MB'
            ]);

            // Pastikan direktori storage ada
            if (!\Storage::disk('public')->exists('ppdb-documents')) {
                \Storage::disk('public')->makeDirectory('ppdb-documents');
            }

            $documents = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    if ($file->isValid()) {
                        $originalName = $file->getClientOriginalName();
                        $filename = time() . '_' . uniqid() . '_' . $originalName;
                        $path = $file->storeAs('ppdb-documents', $filename, 'public');
                        
                        if ($path) {
                            $documents[] = [
                                'path' => $path,
                                'original_name' => $originalName,
                                'size' => $file->getSize()
                            ];
                        }
                    }
                }
            }

            // Generate registration number dengan pengecekan duplikat
            do {
                $registrationNumber = PpdbRegistration::generateRegistrationNumber();
            } while (PpdbRegistration::where('registration_number', $registrationNumber)->exists());

            // Cek apakah user dengan email ini sudah ada
            $user = \App\Models\User::where('email', $validated['email'])->first();
            
            if (!$user) {
                // Buat user baru jika belum ada
                $user = \App\Models\User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['phone']), // Password default: nomor telepon
                    'role' => 'siswa'
                ]);
            }
            
            // Cek apakah user ini sudah pernah mendaftar PPDB
            $existingRegistration = PpdbRegistration::where('user_id', $user->id)->first();
            if ($existingRegistration) {
                return back()->withInput()->with('error', 'Email ini sudah pernah digunakan untuk mendaftar PPDB dengan nomor pendaftaran: ' . $existingRegistration->registration_number);
            }

            $registration = PpdbRegistration::create([
                'user_id' => $user->id,
                'gelombang_id' => 1,
                'jurusan_id' => 1,
                'no_pendaftaran' => $registrationNumber,
                'registration_number' => $registrationNumber,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'birth_date' => $validated['birth_date'],
                'birth_place' => $validated['birth_place'],
                'gender' => $validated['gender'],
                'address' => $validated['address'],
                'school_origin' => $validated['school_origin'],
                'major' => $validated['major'],
                'parent_name' => $validated['parent_name'],
                'parent_phone' => $validated['parent_phone'],
                'parent_job' => $validated['parent_job'],
                'status' => 'pending',
                'payment_status' => 'unpaid'
            ]);

            // Save documents using the relationship
            if (!empty($documents)) {
                foreach ($documents as $index => $document) {
                    $registration->documents()->create([
                        'jenis' => 'LAINNYA',
                        'nama_file' => $document['original_name'],
                        'url' => $document['path'],
                        'ukuran_kb' => round($document['size'] / 1024),
                        'valid' => false
                    ]);
                }
            }

            if ($registration) {
                // Login otomatis
                Auth::login($user);

                // Kirim notifikasi ke keuangan untuk membuat tagihan
                SystemService::createBillNotification($registration->registration_number, 500000);
                
                return redirect()->route('siswa.dashboard')
                    ->with('success', 'Pendaftaran berhasil! Selamat datang di dashboard siswa. Password login Anda adalah nomor telepon.');
            } else {
                throw new \Exception('Gagal menyimpan data pendaftaran');
            }
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('PPDB Registration Error: ' . $e->getMessage(), [
                'request_data' => $request->except(['documents']),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function status($registrationNumber)
    {
        try {
            // Validate registration number format
            if (!preg_match('/^PPDB\d{8}$/', $registrationNumber)) {
                abort(404, 'Format nomor pendaftaran tidak valid');
            }
            
            $registration = PpdbRegistration::where('registration_number', $registrationNumber)
                ->with(['documents', 'payment'])
                ->firstOrFail();
            
            // Cek kelengkapan dokumen
            $requiredDocs = [
                'KK' => 'Fotokopi Kartu Keluarga',
                'AKTA' => 'Fotokopi Akta Kelahiran', 
                'IJAZAH' => 'Fotokopi Ijazah/SKHUN',
                'PAS_FOTO' => 'Pas foto 3x4 (2 lembar)',
                'LAINNYA' => 'Surat keterangan sehat'
            ];
            
            $uploadedDocs = $registration->documents()->pluck('jenis')->toArray();
            $missingDocs = array_diff(array_keys($requiredDocs), $uploadedDocs);
            
            return view('ppdb.status', compact('registration', 'requiredDocs', 'missingDocs'));
        } catch (\Exception $e) {
            return redirect()->route('ppdb.index')->withErrors(['error' => 'Nomor pendaftaran tidak ditemukan.']);
        }
    }

    public function checkStatus(Request $request)
    {
        try {
            $request->validate([
                'registration_number' => 'required|string|regex:/^PPDB\d{8}$/'
            ], [
                'registration_number.regex' => 'Format nomor pendaftaran tidak valid'
            ]);

            $registration = PpdbRegistration::where('registration_number', $request->registration_number)->first();
            
            if (!$registration) {
                return back()->with('error', 'Nomor pendaftaran tidak ditemukan');
            }

            return redirect()->route('ppdb.status', $registration->registration_number);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mencari data pendaftaran.']);
        }
    }

    public function payment($registrationNumber)
    {
        try {
            // Validate registration number format
            if (!preg_match('/^PPDB\d{8}$/', $registrationNumber)) {
                abort(404, 'Format nomor pendaftaran tidak valid');
            }
            
            $registration = PpdbRegistration::where('registration_number', $registrationNumber)->firstOrFail();
            
            // Cek apakah sudah ada pembayaran
            if ($registration->payment && $registration->payment->status !== 'rejected') {
                return redirect()->route('ppdb.status', $registrationNumber)
                    ->with('info', 'Pembayaran sudah dilakukan atau sedang diproses.');
            }
            
            return view('ppdb.payment', compact('registration'));
        } catch (\Exception $e) {
            return redirect()->route('ppdb.index')->withErrors(['error' => 'Nomor pendaftaran tidak ditemukan.']);
        }
    }

    public function processPayment(Request $request, $registrationNumber)
    {
        try {
            // Validate registration number format
            if (!preg_match('/^PPDB\d{8}$/', $registrationNumber)) {
                abort(404, 'Format nomor pendaftaran tidak valid');
            }
            
            $request->validate([
                'payment_method' => 'required|string',
                'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
            ]);

            $registration = PpdbRegistration::where('registration_number', $registrationNumber)->firstOrFail();
        
        // Upload bukti pembayaran
        $file = $request->file('payment_proof');
        $filename = 'payment_' . $registrationNumber . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payment-proofs', $filename, 'public');

            // Update status pembayaran menjadi pending
            $registration->update(['payment_status' => 'pending']);

            // Buat record pembayaran
            $payment = $registration->payment()->create([
                'amount' => 500000, // Biaya pendaftaran
                'payment_method' => $request->payment_method,
                'payment_date' => now(),
                'status' => 'pending',
                'payment_proof' => $path,
                'description' => 'Biaya Pendaftaran PPDB',
                'receipt_number' => 'PAY' . time() . rand(1000, 9999)
            ]);

            // Log activity dan kirim notifikasi
            SystemService::logActivity('payment_uploaded', $payment);
            SystemService::notifyKeuangan(
                'Pembayaran PPDB Baru',
                "Pembayaran untuk pendaftaran {$registrationNumber} perlu diverifikasi",
                'info'
            );

            return redirect()->route('ppdb.status', $registrationNumber)
                ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi dari admin.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses pembayaran.'])->withInput();
        }
    }

    public function documents($registrationNumber)
    {
        $registration = PpdbRegistration::where('registration_number', $registrationNumber)->firstOrFail();
        return view('ppdb.documents-new', compact('registration'));
    }

    public function uploadDocuments(Request $request, $registrationNumber)
    {
        $request->validate([
            'kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pas_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'surat_sehat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $registration = PpdbRegistration::where('registration_number', $registrationNumber)->firstOrFail();
        
        $uploadedCount = 0;
        $documents = ['kk' => 'KK', 'akta' => 'AKTA', 'ijazah' => 'IJAZAH', 'pas_foto' => 'PAS_FOTO', 'surat_sehat' => 'LAINNYA'];
        
        foreach ($documents as $key => $name) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $filename = $key . '_' . $registrationNumber . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('documents', $filename, 'public');

                $registration->documents()->updateOrCreate(
                    ['jenis' => $documents[$key]],
                    [
                        'nama_file' => $file->getClientOriginalName(),
                        'url' => $path,
                        'ukuran_kb' => round($file->getSize() / 1024),
                        'valid' => false
                    ]
                );
                $uploadedCount++;
            }
        }

        if ($uploadedCount > 0) {
            SystemService::notifyAdmin(
                'Dokumen Baru Diupload',
                "$uploadedCount dokumen untuk pendaftaran {$registrationNumber} telah diupload",
                'info'
            );
            return back()->with('success', "$uploadedCount dokumen berhasil diupload dan menunggu verifikasi admin");
        }

        return back()->with('error', 'Tidak ada dokumen yang diupload');
    }

    public function deleteDocument($registrationNumber, $documentId)
    {
        try {
            $registration = PpdbRegistration::where('registration_number', $registrationNumber)->firstOrFail();
            $document = $registration->documents()->findOrFail($documentId);
            
            // Hapus file dari storage
            if (Storage::disk('public')->exists($document->url)) {
                Storage::disk('public')->delete($document->url);
            }
            
            $document->delete();
            
            return back()->with('success', 'Dokumen berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus dokumen');
        }
    }
}