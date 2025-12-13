<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumlahIbuHamil extends Model
{
    protected $table = 'jumlah_ibu_hamil';

    protected $fillable = [
        'year',
        'male',
        'female',
    ];
}
