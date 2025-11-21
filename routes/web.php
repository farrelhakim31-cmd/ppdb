<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PPDBController;
use App\Http\Controllers\PpdbController as NewPpdbController;
use App\Http\Controllers\Admin\PpdbAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentVerificationController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KeuanganInvoiceController;

use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\PaymentNotificationController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminPanitiaController;
use App\Http\Controllers\VerifikatorAdminController;
use App\Http\Controllers\DocumentViewController;

// Status Check Routes (Public)
Route::get('/cek-status', [StatusController::class, 'index'])->name('status.index');
Route::post('/cek-status', [StatusController::class, 'check'])->name('status.check');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.store')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// OTP Routes
Route::middleware(['guest', 'check.otp.session'])->group(function () {
    Route::get('/otp-delivery-choice', [OtpController::class, 'chooseDeliveryMethod'])->name('otp.delivery-choice');
    Route::post('/otp-set-delivery', [OtpController::class, 'setDeliveryMethod'])->name('otp.set-delivery');
    Route::get('/otp-verification', [OtpController::class, 'showOtpForm'])->name('otp.form');
    Route::post('/otp-verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/otp-resend', [OtpController::class, 'resendOtp'])->name('otp.resend');
});

// Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/siswa/dashboard', [DashboardController::class, 'siswa'])->name('siswa.dashboard');
    Route::get('/siswa/status', [DashboardController::class, 'siswaStatus'])->name('siswa.status');
    // Kepala Sekolah Routes
    Route::middleware(['auth', 'role:kepala'])->prefix('kepala')->name('kepala.')->group(function () {
        Route::get('/dashboard', [KepalaSekolahController::class, 'dashboard'])->name('dashboard');
        Route::get('/reports', [KepalaSekolahController::class, 'reports'])->name('reports');
        Route::get('/export', [KepalaSekolahController::class, 'exportReport'])->name('export');
    });
    
    // Verifikator Routes
    Route::middleware(['auth', 'role:verifikator'])->prefix('verifikator')->name('verifikator.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\VerifikatorController::class, 'dashboard'])->name('dashboard');
        Route::get('/pendaftar', [\App\Http\Controllers\VerifikatorController::class, 'index'])->name('index');
        Route::get('/pendaftar/{id}', [\App\Http\Controllers\VerifikatorController::class, 'show'])->name('show');
        Route::post('/pendaftar/{id}/verify', [\App\Http\Controllers\VerifikatorController::class, 'verify'])->name('verify');
        Route::post('/document/{id}/validate', [\App\Http\Controllers\VerifikatorController::class, 'validateDocument'])->name('validate-document');
    });
    
    // Verifikator Admin Routes
    Route::middleware(['auth', 'role:verifikator'])->prefix('verifikator-admin')->name('verifikator-admin.')->group(function () {
        Route::get('/dashboard', [VerifikatorAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pendaftar', [VerifikatorAdminController::class, 'index'])->name('index');
        Route::get('/pendaftar/{id}', [VerifikatorAdminController::class, 'show'])->name('show');
        Route::post('/pendaftar/{id}/verify', [VerifikatorAdminController::class, 'verify'])->name('verify');
        Route::get('/document/{id}', [DocumentViewController::class, 'show'])->name('document.show');
        Route::post('/notify-student/{id}', [NotificationController::class, 'notifyStudent'])->name('notify-student');
        Route::post('/request-reupload/{id}', [NotificationController::class, 'requestReupload'])->name('request-reupload');
    });
    
    // Admin Panitia Routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin-panitia')->name('admin-panitia.')->group(function () {
        Route::get('/dashboard', [AdminPanitiaController::class, 'dashboard'])->name('dashboard');
        Route::get('/monitoring', [AdminPanitiaController::class, 'monitoring'])->name('monitoring');
        Route::get('/map', [AdminPanitiaController::class, 'mapSebaran'])->name('map');
        Route::get('/master-data', [AdminPanitiaController::class, 'masterData'])->name('master-data');
        Route::get('/reports', [AdminPanitiaController::class, 'reports'])->name('reports');
        Route::get('/accounts', [AdminPanitiaController::class, 'accounts'])->name('accounts');
        Route::get('/export', [AdminPanitiaController::class, 'exportData'])->name('export');
        Route::post('/jurusan', [AdminPanitiaController::class, 'storeJurusan'])->name('store-jurusan');
        Route::put('/jurusan/{jurusan}', [AdminPanitiaController::class, 'updateJurusan'])->name('update-jurusan');
        Route::patch('/jurusan/{jurusan}/toggle', [AdminPanitiaController::class, 'toggleJurusan'])->name('toggle-jurusan');
        Route::post('/gelombang', [AdminPanitiaController::class, 'storeGelombang'])->name('store-gelombang');
        Route::put('/gelombang/{gelombang}', [AdminPanitiaController::class, 'updateGelombang'])->name('update-gelombang');
        Route::patch('/gelombang/{gelombang}/toggle', [AdminPanitiaController::class, 'toggleGelombang'])->name('toggle-gelombang');
        Route::post('/pembayaran', [AdminPanitiaController::class, 'storePembayaran'])->name('store-pembayaran');
        Route::post('/dokumen', [AdminPanitiaController::class, 'storeDokumen'])->name('store-dokumen');
        Route::post('/provinsi', [AdminPanitiaController::class, 'storeProvinsi'])->name('store-provinsi');
        Route::post('/sync-data', [AdminPanitiaController::class, 'syncData'])->name('sync-data');
        Route::post('/backup-data', [AdminPanitiaController::class, 'backupData'])->name('backup-data');
        Route::post('/clear-cache', [AdminPanitiaController::class, 'clearCache'])->name('clear-cache');
        Route::post('/update-info-ppdb', [AdminPanitiaController::class, 'updateInfoPpdb'])->name('update-info-ppdb');
        Route::post('/users', [AdminPanitiaController::class, 'storeUser'])->name('store-user');
        Route::put('/users/{id}', [AdminPanitiaController::class, 'updateUser'])->name('update-user');
        Route::delete('/users/{id}', [AdminPanitiaController::class, 'deleteUser'])->name('delete-user');
        Route::get('/users/{id}', [AdminPanitiaController::class, 'getUser'])->name('get-user');
        Route::post('/accept-student/{id}', [AdminPanitiaController::class, 'acceptStudent'])->name('accept-student');
        Route::post('/send-notification/{id}', [AdminPanitiaController::class, 'sendNotification'])->name('send-notification');
        Route::post('/send-bulk-email', [AdminPanitiaController::class, 'sendBulkEmail'])->name('send-bulk-email');
    });
    Route::get('/keuangan/dashboard', [DashboardController::class, 'keuangan'])->name('keuangan.dashboard');
});

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Test OTP Route (untuk development)
Route::get('/test-otp', function () {
    return view('test-otp');
})->name('test.otp');

// Front-End Routes (Portal Pendaftar) - Sistem Baru
Route::prefix('ppdb-new')->name('ppdb.')->group(function () {
    Route::get('/', [NewPpdbController::class, 'index'])->name('index');
    Route::get('/daftar', [NewPpdbController::class, 'create'])->name('register');
    Route::post('/daftar', [NewPpdbController::class, 'store'])->name('store');
    Route::get('/status/{registrationNumber}', function() { return redirect()->route('siswa.status'); })->name('status');
    Route::post('/cek-status', [NewPpdbController::class, 'checkStatus'])->name('check-status');
});

// Back Office Routes (Admin Only)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('ppdb')->name('ppdb.')->group(function () {
        Route::get('/', [PpdbAdminController::class, 'index'])->name('index');
        Route::get('/export', [PpdbAdminController::class, 'exportReport'])->name('export');
        Route::get('/export-pdf', [PpdbAdminController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/{registration}', [PpdbAdminController::class, 'show'])->name('show');
        Route::get('/{registration}/requirements', [PpdbAdminController::class, 'checkRequirements'])->name('requirements');
        Route::post('/{registration}/verify', [PpdbAdminController::class, 'verify'])->name('verify');
        Route::post('/{registration}/accept', [PpdbAdminController::class, 'accept'])->name('accept');
        Route::post('/{registration}/reject', [PpdbAdminController::class, 'reject'])->name('reject');
        Route::delete('/{registration}', [PpdbAdminController::class, 'destroy'])->name('destroy');
        Route::post('/document/{document}/validate', [PpdbAdminController::class, 'validateDocument'])->name('validate-document');
    });
    
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
    
    // Map Settings Routes
    Route::get('/map-settings', [\App\Http\Controllers\MapSettingController::class, 'edit'])->name('map-settings.edit');
    Route::put('/map-settings', [\App\Http\Controllers\MapSettingController::class, 'update'])->name('map-settings.update');
});

// Notification Routes
Route::middleware('auth')->group(function () {
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('audit-logs', [NotificationController::class, 'auditLogs'])->name('audit.logs');
});

// Finance Routes
Route::middleware('auth')->group(function () {
    // Bills Routes
    Route::get('bills/unpaid-students', [BillController::class, 'unpaidStudents'])->name('bills.unpaid-students');
    Route::post('bills/{bill}/send-email', [BillController::class, 'sendEmail'])->name('bills.send-email');
    Route::resource('bills', BillController::class)->only(['index', 'create', 'store', 'show']);

    Route::get('payments/verification', [PaymentVerificationController::class, 'index'])->name('payments.verification');
    Route::post('payments/{payment}/verify', [PaymentVerificationController::class, 'verify'])->name('payments.verify');
    Route::get('payments/{payment}', [PaymentVerificationController::class, 'show'])->name('payments.show');
    
    // Keuangan PPDB Routes - Hanya untuk role keuangan
    Route::middleware(['auth', 'role:keuangan'])->group(function () {
        Route::get('keuangan/ppdb', [KeuanganController::class, 'ppdb'])->name('keuangan.ppdb');
        Route::get('keuangan/ppdb/{id}', [KeuanganController::class, 'ppdbDetail'])->name('keuangan.ppdb.detail');
        Route::post('keuangan/ppdb/{id}/verify', [KeuanganController::class, 'verifyPayment'])->name('keuangan.ppdb.verify');
        Route::post('keuangan/ppdb/{id}/create-bill', [KeuanganController::class, 'createBill'])->name('keuangan.ppdb.create-bill');
        Route::post('keuangan/ppdb/send-bulk-reminder', [KeuanganController::class, 'sendBulkPaymentReminder'])->name('keuangan.ppdb.send-bulk-reminder');
        
        // Keuangan Invoice Routes
        Route::prefix('keuangan')->name('keuangan.')->group(function () {
            Route::get('invoices', [KeuanganInvoiceController::class, 'index'])->name('invoices.index');
            Route::get('invoices/create', [KeuanganInvoiceController::class, 'create'])->name('invoices.create');
            Route::post('invoices', [KeuanganInvoiceController::class, 'store'])->name('invoices.store');
            Route::get('invoices/{invoice}', [KeuanganInvoiceController::class, 'show'])->name('invoices.show');
            Route::patch('invoices/{invoice}/mark-paid', [KeuanganInvoiceController::class, 'markAsPaid'])->name('invoices.mark-paid');
        });
    });
    

    
    // Student Invoice Routes
    Route::get('student/invoices', [InvoiceController::class, 'studentInvoices'])->name('student.invoices');
    
    // Payment Notification Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('payment-notifications', [PaymentNotificationController::class, 'index'])->name('payment-notifications.index');
        Route::get('payment-notifications/create', [PaymentNotificationController::class, 'create'])->name('payment-notifications.create');
        Route::post('payment-notifications', [PaymentNotificationController::class, 'store'])->name('payment-notifications.store');
    });
    
    // Student Payment Notifications
    Route::get('student/payment-notifications', [PaymentNotificationController::class, 'studentNotifications'])->name('student.payment-notifications');
    Route::post('student/payment-notifications/{id}/read', [PaymentNotificationController::class, 'markAsRead'])->name('student.payment-notifications.read');
    

});

// Routes PPDB Lama
Route::get('/ppdb', [PPDBController::class, 'index'])->name('ppdb.index');
Route::get('/ppdb/register', [PPDBController::class, 'register'])->name('ppdb.register');
Route::post('/ppdb/register', [PPDBController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/payment/{id}', [PPDBController::class, 'payment'])->name('ppdb.payment');
Route::post('/ppdb/payment/{id}', [PPDBController::class, 'processPayment'])->name('ppdb.process-payment');
Route::get('/ppdb/status/{id}', [PPDBController::class, 'status'])->name('ppdb.status');
Route::post('/ppdb/check-status', [PPDBController::class, 'checkStatus'])->name('ppdb.check-status');
Route::get('/ppdb/documents/{id}', [PPDBController::class, 'documents'])->name('ppdb.documents');
Route::post('/ppdb/documents/{id}', [PPDBController::class, 'uploadDocuments'])->name('ppdb.upload-documents');
Route::delete('/ppdb/documents/{registrationNumber}/{documentId}', [PPDBController::class, 'deleteDocument'])->name('ppdb.delete-document');

// Routes lama (untuk kompatibilitas)
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses');
Route::get('/team', [HomeController::class, 'team'])->name('team');
Route::get('/testimonial', [HomeController::class, 'testimonial'])->name('testimonial');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
