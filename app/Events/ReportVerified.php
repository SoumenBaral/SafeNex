<?php

namespace App\Events;

use App\Models\Report;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportVerified implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Report $report) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('incidents'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'incident' => [
                'id' => $this->report->id,
                'title' => $this->report->title,
                'latitude' => $this->report->latitude,
                'longitude' => $this->report->longitude,
                'severity' => $this->report->severity,
                'category_name' => $this->report->category?->name,
                'category_color' => $this->report->category?->color,
                'district_name' => $this->report->district?->name,
                'upazila_name' => $this->report->upazila?->name,
                'created_at' => $this->report->created_at,
            ],
        ];
    }
}
