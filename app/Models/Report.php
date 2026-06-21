<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'description',
        'district_id', 'upazila_id', 'address',
        'latitude', 'longitude', 'severity', 'status',
        'verified_by', 'verified_at', 'rejection_reason', 'occurred_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'occurred_at' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function media(): HasMany
    {
        return $this->hasMany(ReportMedia::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TeamAssignment::class);
    }

    public function newsArticle(): HasOne
    {
        return $this->hasOne(NewsArticle::class);
    }
}
