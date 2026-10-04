<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitDefinition extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category', 'is_system_preset'];

    protected function casts(): array
    {
        return ['is_system_preset' => 'boolean'];
    }

    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }
}