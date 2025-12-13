<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosyanduRekap extends Model
{
    protected $fillable = [
        'year',
        'code',
        'value',
        'male',
        'female',
    ];
}
