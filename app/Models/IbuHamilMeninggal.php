<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamilMeninggal extends Model
{
    protected $table = 'ibu_hamil_meninggal';

    protected $fillable = [
        'tahun',
        'bulan',
        'jumlah',
    ];
}
