<?php

namespace App\Jobs;

use App\Mail\RescueAssignmentMail;
use App\Models\TeamAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyRescueTeam implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public TeamAssignment $assignment) {}

    public function handle(): void
    {
        $this->assignment->load('team.members', 'report.category', 'report.district', 'report.upazila');

        foreach ($this->assignment->team->members as $member) {
            Mail::to($member->email)->queue(
                new RescueAssignmentMail($this->assignment, $member)
            );
        }

        $this->assignment->update(['emailed_at' => now()]);
    }
}
