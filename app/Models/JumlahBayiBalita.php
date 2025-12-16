<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumlahBayiBalita extends Model
{
    protected $table = 'jumlah_bayi_balita';

    protected $fillable = [
        'tahun',
        'usia_kategori',
        'laki_laki',
        'perempuan',
    ];
}
