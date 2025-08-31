<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Resume extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeFactory> */
    use HasFactory;

    protected $fillable = ['tel','title','summary','status'];
    
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function personalAddress(): MorphOne {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function image(): HasOne {
        return $this->hasOne(Image::class);
    }

    public function experiences(): HasMany {
        return $this->hasMany(Experience::class);
    }

    public function skills(): HasMany {
        return $this->hasMany(Skill::class);
    }    

    public function educations(): HasMany {
        return $this->hasMany(Education::class);
    }    

    public function portfolios(): HasMany {
        return $this->hasMany(Portfolio::class);
    }

    public function references(): HasMany {
        return $this->hasMany(Reference::class);
    }
}
