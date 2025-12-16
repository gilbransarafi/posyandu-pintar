<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamilAnemia extends Model
{
    protected $table = 'jumlah_ibu_hamil_anemia';

    protected $fillable = [
        'tahun',
        'bulan',
        'jumlah',
    ];
}
