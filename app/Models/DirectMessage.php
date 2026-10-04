<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'sender_user_id',
        'encrypted_message_body',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'encrypted_message_body' => 'encrypted',
            'read_at' => 'datetime',
        ];
    }

    public function thread()
    {
        return $this->belongsTo(DirectMessageThread::class, 'thread_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }
}