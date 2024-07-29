<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banggota extends Model
{
    use HasFactory;
    protected $table = 'dinas_b_anggota'; 
    protected $fillable = [ 
        'kdDinas',
        'kdBidang',
        'kdBAnggota',
        'nmAnggota',
        'nmJabatan',

        'nip',
        'status',
        'taBAnggota',
        'asJabatan',
        'golongan',
        'tingkatan',
        'snip',
        
        'urutan',
        'aktif', 
    ]; 
}
