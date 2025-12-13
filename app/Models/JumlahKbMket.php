<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumlahKbMket extends Model
{
    protected $table = 'jumlah_kb_mket';

    protected $fillable = [
        'year',
        'male',
        'female',
    ];
}
