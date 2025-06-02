<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentNotificationMail;
use App\Events\AppointmentBooked;

class SendAppointmentNotificationMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        Log::info('SendAppointmentNotificationMail listener constructed');
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentBooked $event): void
    {
        Log::info('SendAppointmentNotificationMail listener started', [
            'appointment_id' => $event->appointment->id
        ]);

        try {
            if (!$event->appointment->patient || !$event->appointment->patient->email) {
                Log::error('Cannot send appointment notification: Patient or patient email not found', [
                    'appointment_id' => $event->appointment->id
                ]);
                return;
            }

            
                
            Log::info('Appointment notification email sent successfully', [
                'appointment_id' => $event->appointment->id,
                'patient_email' => $event->appointment->patient->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send appointment notification email', [
                'appointment_id' => $event->appointment->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
