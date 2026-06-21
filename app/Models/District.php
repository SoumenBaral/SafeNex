<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $fillable = ['name', 'name_bn', 'lat', 'lng'];

    public function upazilas(): HasMany
    {
        return $this->hasMany(Upazila::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
