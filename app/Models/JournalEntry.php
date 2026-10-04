<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_type',
        'encrypted_title',
        'encrypted_body',
        'sentiment_heuristic',
    ];

    /**
     * Native AES-256 encryption at rest
     */
    protected function casts(): array
    {
        return [
            'encrypted_title' => 'encrypted',
            'encrypted_body' => 'encrypted',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}