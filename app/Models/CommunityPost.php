<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['group_id', 'user_id', 'body', 'is_quarantined'];

    protected function casts(): array
    {
        return ['is_quarantined' => 'boolean'];
    }

    public function group()
    {
        return $this->belongsTo(CommunityGroup::class, 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(CommunityComment::class, 'post_id');
    }
    
public function reactions(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(PostReaction::class, 'post_id');
}
}