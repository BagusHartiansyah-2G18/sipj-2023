<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dinas extends Model
{
    
    use HasFactory;
    protected $table = 'dinas'; 
    protected $fillable = [ 
        'kdDinas',
        'nmDinas',
        'asDinas',
        'kadis',
        'nip',
        'taDinas',
        'alamat' 
    ];
}
