<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeAccess extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeAccessFactory> */
    use HasFactory;

    function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    
     protected function casts(): array
    {
        return [
            'access_key' => 'hashed',
        ];
    }
}
