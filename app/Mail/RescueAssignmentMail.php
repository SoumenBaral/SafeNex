<?php

namespace App\Mail;

use App\Models\RescueTeamMember;
use App\Models\TeamAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RescueAssignmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public TeamAssignment $assignment,
        public RescueTeamMember $member
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Emergency Assignment: {$this->assignment->report->title}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.rescue-assignment',
        );
    }
}
