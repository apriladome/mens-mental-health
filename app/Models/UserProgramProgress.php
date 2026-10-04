<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgramProgress extends Model
{
    use HasFactory;

    protected $table = 'user_program_progress';

    protected $fillable = [
        'user_id',
        'program_id',
        'last_completed_lesson_id',
        'status',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
      public function lastCompletedLesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'last_completed_lesson_id');
    }
}