<x-mail::message>
# Emergency Rescue Assignment

Hello **{{ $member->name }}**,

You have been assigned to an emergency incident as part of **{{ $assignment->team->name }}**.

## Incident Details

- **Title:** {{ $assignment->report->title }}
- **Category:** {{ $assignment->report->category?->name }}
- **Severity:** {{ ucfirst($assignment->report->severity) }}
- **Location:** {{ $assignment->report->district?->name }}{{ $assignment->report->upazila ? ' / ' . $assignment->report->upazila->name : '' }}
- **Address:** {{ $assignment->report->address ?? 'N/A' }}
- **Coordinates:** {{ $assignment->report->latitude }}, {{ $assignment->report->longitude }}

## Assignment Reason

{{ $assignment->reason }}

## Your Role

{{ $member->role_in_team ?? 'Team Member' }}

<x-mail::button url="https://maps.google.com/?q={{ $assignment->report->latitude }},{{ $assignment->report->longitude }}">
View on Google Maps
</x-mail::button>

Please coordinate with your team leader and report to the incident location as soon as possible.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
