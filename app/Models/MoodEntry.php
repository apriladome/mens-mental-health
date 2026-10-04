<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoodEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'energy_level',
        'irritability_level',
        'focus_level',
        'sleep_quality',
        'logged_date',
    ];

    protected function casts(): array
    {
        return [
            'logged_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}