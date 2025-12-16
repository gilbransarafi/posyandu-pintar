<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumlahKbNonMket extends Model
{
    protected $table = 'jumlah_kb_non_mket';

    protected $fillable = [
        'year',
        'bulan',
        'jumlah',
        'male',
        'female',
    ];
}
