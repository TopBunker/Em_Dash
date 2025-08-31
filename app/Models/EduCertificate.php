<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EduCertificate extends Model
{
    /** @use HasFactory<\Database\Factories\EduCertificateFactory> */
    use HasFactory;

    protected $fillable = ['name','issued_by','issued_at'];

    public function education(): BelongsTo {
        return $this->belongsTo(Education::class);
    }
}
