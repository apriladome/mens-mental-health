<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrisisEscalationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trigger_source',
        'severity_level',
        'intercept_viewed',
        'clinician_dispatched_id',
        'resolved_at',
        'resolution_notes',
    ];

    protected $casts = [
        'intercept_viewed' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clinicianDispatched(): BelongsTo
    {
        return $this->belongsTo(User::class, 'clinician_dispatched_id');
    }
}