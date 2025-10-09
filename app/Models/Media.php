<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = ['location', 'thumb', 'title', 'type'];

    public function mediable(): MorphTo {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string {
        return asset($this->thumb ?? $this->location);
    }   
}
