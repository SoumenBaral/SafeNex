<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RescueTeam extends Model
{
    protected $fillable = ['name', 'leader_name', 'leader_phone', 'leader_email', 'district_id', 'status'];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(RescueTeamMember::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TeamAssignment::class);
    }
}
