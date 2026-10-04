<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\CrisisEscalationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClinicalEmergencyAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        public CrisisEscalationLog $escalationLog
    ) {}

    /**
     * Notification channels (mail and internal database).
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Masked transactional email for on-call clinical supervisors.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->error()
            ->subject('[URGENT] Safety Triage Alert #' . $this->escalationLog->id)
            ->line('A clinical safety threshold has been triggered on the platform.')
            ->line('Severity Level: ' . strtoupper($this->escalationLog->severity_level))
            ->line('Trigger Source: ' . $this->escalationLog->trigger_source)
            ->action('Access Clinical Command Center', url('/admin/crisis-escalation-logs/' . $this->escalationLog->id))
            ->line('Immediate clinical triage review is required.');
    }

    /**
     * Database record for in-app alert badge in Filament command center.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'escalation_id' => $this->escalationLog->id,
            'user_id' => $this->escalationLog->user_id,
            'severity_level' => $this->escalationLog->severity_level,
            'trigger_source' => $this->escalationLog->trigger_source,
        ];
    }
}