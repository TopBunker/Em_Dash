<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;

    protected $fillable = ['line_1','line_2','city','state','country_code','zip'];

    public function country(): BelongsTo {
        return $this->belongsTo(Country::class);
    }

    public function addressable(): MorphTo {
        return $this->morphTo();
    }
}
