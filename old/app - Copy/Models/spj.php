<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spj extends Model
{
    use HasFactory;
    protected $fillable = [
        'kdDinas',
        'kdBidang',
        'kdSub',
        'kdJudul',
        'data',
        'volume',
        'no',

        'satuan',
        'totVol',
        'totSatuan',
        'keterangan',
        'an', 
        'taSPJ',
        'idMember',
        'status'
    ];
}
