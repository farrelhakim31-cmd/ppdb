<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\NotificationService;
use App\Models\PpdbRegistration;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $registrationId;
    protected $notificationType;
    protected $additionalData;

    public function __construct($registrationId, $notificationType, $additionalData = [])
    {
        $this->registrationId = $registrationId;
        $this->notificationType = $notificationType;
        $this->additionalData = $additionalData;
    }

    public function handle(NotificationService $notificationService)
    {
        $registration = PpdbRegistration::find($this->registrationId);
        
        if (!$registration) {
            return;
        }

        switch ($this->notificationType) {
            case 'registration_confirmation':
                $notificationService->sendRegistrationConfirmation($registration);
                break;
                
            case 'payment_reminder':
                $notificationService->sendPaymentReminder($registration);
                break;
                
            case 'document_request':
                $documentType = $this->additionalData['document_type'] ?? 'berkas';
                $notificationService->sendDocumentRequest($registration, $documentType);
                break;
                
            case 'verification_result':
                $status = $this->additionalData['status'];
                $notes = $this->additionalData['notes'] ?? null;
                $notificationService->sendVerificationResult($registration, $status, $notes);
                break;
                
            case 'payment_confirmation':
                $notificationService->sendPaymentConfirmation($registration);
                break;
        }
    }
}