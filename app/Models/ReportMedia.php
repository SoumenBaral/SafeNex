<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportMedia extends Model
{
    protected $fillable = ['report_id', 'type', 'disk', 'path', 'thumbnail_path', 'mime', 'size'];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
