<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Upazila extends Model
{
    protected $fillable = ['district_id', 'name', 'name_bn', 'lat', 'lng'];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
