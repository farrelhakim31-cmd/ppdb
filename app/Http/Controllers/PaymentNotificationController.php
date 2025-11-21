<?php

namespace App\Http\Controllers;

use App\Models\PaymentNotification;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentNotificationController extends Controller
{
    public function index()
    {
        $notifications = PaymentNotification::with('user')->latest()->paginate(10);
        return view('admin.payment-notifications.index', compact('notifications'));
    }

    public function create()
    {
        $students = User::where('role', 'siswa')->get();
        return view('admin.payment-notifications.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after:today'
        ]);

        PaymentNotification::create($request->all());

        return redirect()->route('admin.payment-notifications.index')
            ->with('success', 'Notifikasi pembayaran berhasil dikirim');
    }

    public function studentNotifications()
    {
        $notifications = PaymentNotification::where('user_id', auth()->id())
            ->latest()
            ->get();
        
        return view('student.payment-notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = PaymentNotification::where('user_id', auth()->id())
            ->findOrFail($id);
        
        $notification->update(['is_read' => true]);
        
        return back();
    }
}