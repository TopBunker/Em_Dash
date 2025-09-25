<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Experience extends Model
{
    /** @use HasFactory<\Database\Factories\EducationFactory> */
    use HasFactory;

    protected $fillable = ['start_date','end_date','position','employer','business_type'];

    public function resume(): BelongsTo {
        return $this->belongsTo(Resume::class);
    }

    public function tasks(): HasMany {
        return $this->hasMany(Task::class);
    }

    public function accomplishments(): HasOneOrMany {
        return $this->hasMany(Accomplishment::class);
    }

    public function employerAddress(): MorphOne {
        return $this->morphOne(Address::class, 'addressable');
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date: F Y',
            'end_date' => 'date: F Y'
        ];
    }
}
