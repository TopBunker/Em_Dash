<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EduDetail extends Model
{
    /** @use HasFactory<\Database\Factories\EduDetailFactory> */
    use HasFactory;

    protected $primaryKey = 'education_id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $fillable = ['detail'];

    public function education(): BelongsTo {
        return $this->belongsTo(Education::class, 'education_id','id');
    }
}
