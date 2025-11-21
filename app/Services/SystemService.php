<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendBillNotification;

class SystemService
{
    public static function logActivity($action, $model = null, $description = null)
    {
        try {
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'model_type' => $model ? get_class($model) : null,
                'model_id' => $model ? $model->id : null,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }

    public static function notifyKeuangan($title, $message, $type = 'info')
    {
        try {
            $keuanganUsers = User::whereIn('role', ['admin', 'keuangan'])->get();
            
            foreach ($keuanganUsers as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $title,
                    'message' => $message,
                    'type' => $type
                ]);
                
                Log::info("Notification sent to {$user->email}: {$title}");
            }
        } catch (\Exception $e) {
            Log::error('Failed to send notification: ' . $e->getMessage());
        }
    }

    public static function notifyAdmin($title, $message, $type = 'info')
    {
        try {
            $adminUsers = User::where('role', 'admin')->get();
            
            foreach ($adminUsers as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $title,
                    'message' => $message,
                    'type' => $type
                ]);
                
                Log::info("Notification sent to admin {$user->email}: {$title}");
            }
        } catch (\Exception $e) {
            Log::error('Failed to send notification: ' . $e->getMessage());
        }
    }

    public static function notifyUser($userId, $title, $message, $type = 'info')
    {
        try {
            Notification::create([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type
            ]);
            
            Log::info("Notification sent to user {$userId}: {$title}");
        } catch (\Exception $e) {
            Log::error('Failed to send notification: ' . $e->getMessage());
        }
    }

    public static function createBillNotification($registrationId, $amount)
    {
        try {
            // Dispatch job untuk mengirim notifikasi
            SendBillNotification::dispatch($registrationId, $amount);
            
            self::logActivity('bill_notification_queued', null, "Bill notification queued for registration {$registrationId}");
        } catch (\Exception $e) {
            Log::error('Failed to queue bill notification: ' . $e->getMessage());
        }
    }
}