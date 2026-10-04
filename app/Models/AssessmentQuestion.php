<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['assessment_id', 'order', 'question_text', 'options_json', 'is_critical_flag'];

    protected function casts(): array
    {
        return [
            'options_json' => 'array',
            'is_critical_flag' => 'boolean',
        ];
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}