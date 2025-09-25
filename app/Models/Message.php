<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    protected $fillable = ['user_id','name','mail','subject', 'message'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany {
        return $this->hasMany(Document::class);
    }
}
