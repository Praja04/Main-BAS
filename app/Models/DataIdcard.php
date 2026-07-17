<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataIdcard extends Model
{
    use HasFactory;

    protected $table = 'data_idcard';

    protected $fillable = [
        'sn_card',
        'nik',
        'nama',
        'dept',
    ];
}
