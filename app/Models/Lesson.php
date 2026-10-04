<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'order',
        'slug',
        'title',
        'reading_time_minutes',
        'body_content',
        'audio_media_url',
        'interactive_tool_type',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}