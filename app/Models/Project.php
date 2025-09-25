<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{
    protected $fillable = ['title','details','link'];

    public function portfolio(): BelongsTo {
        return $this->belongsTo(Portfolio::class);
    }

    public function projectMedia(): MorphMany {
        return $this->morphMany(Media::class, 'mediaable');
    }
}
