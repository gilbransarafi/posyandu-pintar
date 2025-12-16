<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamilKek extends Model
{
    protected $table = 'jumlah_ibu_hamil_kek';

    protected $fillable = [
        'tahun',
        'bulan',
        'jumlah',
    ];
}
