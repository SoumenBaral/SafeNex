<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamAssignment extends Model
{
    protected $fillable = ['report_id', 'rescue_team_id', 'assigned_by', 'reason', 'status', 'emailed_at'];

    protected function casts(): array
    {
        return [
            'emailed_at' => 'datetime',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(RescueTeam::class, 'rescue_team_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
