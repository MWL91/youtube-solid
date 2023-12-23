<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'result',
        'chart_standard_url',
        'chart_bvs_url',
        'rate_1',
        'rate_2',
        'rate_3',
        'rate_4',
        'rate_5',
        'data',
        'deep_analitics',
    ];

    protected $casts = [
        'data' => 'json',
    ];
}
