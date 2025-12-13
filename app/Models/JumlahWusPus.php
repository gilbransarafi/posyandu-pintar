<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumlahWusPus extends Model
{
    protected $table = 'jumlah_wus_pus';

    protected $fillable = [
        'year',
        'male',
        'female',
    ];
}
