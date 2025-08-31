<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Accomplishment extends Model
{
    /** @use HasFactory<\Database\Factories\AccomplishmentFactory> */
    use HasFactory;

    protected $fillable = ['heading','accomplishment'];

    public function experience(): BelongsTo {
        return $this->belongsTo(Experience::class);
    }
}
