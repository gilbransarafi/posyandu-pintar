<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamilRisikoTinggi extends Model
{
    protected $table = 'ibu_hamil_risiko_tinggi';

    protected $fillable = ['tahun', 'bulan', 'jumlah'];
}
