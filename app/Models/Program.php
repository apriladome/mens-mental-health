<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'summary',
        'tier_requirement',
        'estimated_completion_days',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'estimated_completion_days' => 'integer',
        ];
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function progress()
    {
        return $this->hasMany(UserProgramProgress::class);
    }
}