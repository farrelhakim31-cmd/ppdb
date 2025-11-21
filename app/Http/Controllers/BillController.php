<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Student;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role, ['admin', 'keuangan'])) {
                abort(403, 'Akses ditolak');
            }
            return $next($request);
        });
    }
    public function index()
    {
        $bills = Bill::with('student')->latest()->paginate(10);
        return view('admin.bills.index', compact('bills'));
    }

    public function create()
    {
        $students = Student::all();
        return view('admin.bills.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'description' => 'required|string'
        ]);

        $bill = Bill::create([
            'student_id' => $request->student_id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'status' => 'unpaid',
            'created_by' => auth()->id()
        ]);

        if ($request->has('send_email')) {
            $bill->load('student');
            \Mail::to($bill->student->email)->send(new \App\Mail\BillNotification($bill));
        }

        return redirect()->route('bills.index')->with('success', 'Tagihan berhasil dibuat' . ($request->has('send_email') ? ' dan email telah dikirim' : ''));
    }

    public function show(Bill $bill)
    {
        $bill->load('student', 'payments');
        return view('admin.bills.show', compact('bill'));
    }

    public function unpaidStudents()
    {
        $students = Student::with(['payments' => function($query) {
            $query->where('status', 'pending')->orWhere('status', 'unpaid');
        }])->whereHas('payments', function($query) {
            $query->where('status', '!=', 'paid');
        })->orWhereDoesntHave('payments')->get();

        return view('admin.bills.unpaid-students', compact('students'));
    }

    public function sendEmail(Bill $bill)
    {
        try {
            $bill->load('student');
            \Mail::to($bill->student->email)->send(new \App\Mail\BillNotification($bill));
            return response()->json(['success' => true, 'message' => 'Email berhasil dikirim']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}