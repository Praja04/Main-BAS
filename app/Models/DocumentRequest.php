<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'req_number',
        'request_date',
        'user_id',
        'type_of_req',
        'revision_number',
        'type_of_doc',
        'doc_number',
        'doc_title',
        'detail_before',
        'detail_after',
        'file_path',
        'status',
        'revision_count'
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
