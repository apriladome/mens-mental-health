<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['post_id', 'user_id', 'body', 'is_quarantined'];

    protected function casts(): array
    {
        return ['is_quarantined' => 'boolean'];
    }

    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}