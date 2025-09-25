<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Education extends Model
{
    /** @use HasFactory<\Database\Factories\EducationFactory> */
    use HasFactory;

    protected $table = 'educations';
    
    protected $fillable = ['institution','start_date','end_date','degree','level'];

    public function resume(): BelongsTo {
        return $this->belongsTo(Resume::class);
    }
    
    public function eduDetail(): HasOne {
        return $this->hasOne(EduDetail::class,'education_id','id');
    }

    public function eduCertificates(): HasMany {
        return $this->hasMany(EduCertificate::class);
    }

    public function institutionAddress(): MorphOne {
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
