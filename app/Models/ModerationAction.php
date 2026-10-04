<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModerationAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'moderator_user_id',
        'action_taken',
        'notes',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(ModerationReport::class);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_user_id');
    }
}