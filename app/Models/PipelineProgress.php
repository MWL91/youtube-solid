<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PipelineProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'payload'
    ];

    protected $casts = [
        'payload' => 'array'
    ];
}
