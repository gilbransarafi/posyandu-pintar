<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosyanduStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'month',
        'year',
        'value',
    ];
}
