<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewVerifiedReport extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Report $report) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'      => 'new_verified_report',
            'report_id' => $this->report->id,
            'title'     => $this->report->title,
            'severity'  => $this->report->severity,
            'district'  => $this->report->district?->name,
            'message'   => "New verified incident: \"{$this->report->title}\" in {$this->report->district?->name}.",
        ];
    }

    public function toBroadcast(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}
