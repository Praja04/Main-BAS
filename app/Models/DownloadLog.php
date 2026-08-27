<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'master_document_id',
        'downloaded_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function masterDocument()
    {
        return $this->belongsTo(MasterDocument::class);
    }
}
