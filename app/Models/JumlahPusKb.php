<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumlahPusKb extends Model
{
    protected $table = 'jumlah_pus_kb';

    protected $fillable = [
        'year',
        'male',
        'female',
    ];
}
