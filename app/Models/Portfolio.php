<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioFactory> */
    use HasFactory;

    protected $fillable = ['title','description','link'];

    public function resume(): BelongsTo {
        return $this->belongsTo(Resume::class);
    }

    public function projects(): HasMany {
        return $this->hasMany(Project::class);
    }
}
