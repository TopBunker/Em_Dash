<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    protected $primaryKey = 'resume_id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $guarded = ['*'];

    public function resume(): BelongsTo {
        return $this->belongsTo(Resume::class,'resume_id','id');
    }
}
