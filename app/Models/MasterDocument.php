<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_number',
        'doc_title',
        'type_of_doc'
    ];
}
