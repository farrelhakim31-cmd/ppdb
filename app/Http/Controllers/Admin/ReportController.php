<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = PpdbRegistration::query();

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.reports.index', compact('registrations'));
    }

    public function export(Request $request)
    {
        $query = PpdbRegistration::query();

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->status) {
            $query->where('status', $request->status);
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
}