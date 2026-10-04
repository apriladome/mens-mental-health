<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityGroup extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'description', 'is_private'];

    protected function casts(): array
    {
        return ['is_private' => 'boolean'];
    }

    public function posts()
    {
        return $this->hasMany(CommunityPost::class, 'group_id');
    }
}