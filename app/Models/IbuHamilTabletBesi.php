<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamilTabletBesi extends Model
{
    protected $table = 'ibu_hamil_tablet_besi';

    protected $fillable = [
        'tahun',
        'bulan',
        'fe1',
        'fe3',
    ];
}
