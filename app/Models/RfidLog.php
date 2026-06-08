<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfidLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sn_card',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];
}
