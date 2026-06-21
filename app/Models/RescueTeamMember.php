<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RescueTeamMember extends Model
{
    protected $fillable = ['rescue_team_id', 'name', 'email', 'phone', 'role_in_team'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(RescueTeam::class, 'rescue_team_id');
    }
}
