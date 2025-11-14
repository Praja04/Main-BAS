<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UserPortal extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'portal_name',
        'portal_url',
        'username_portal',
        'password_portal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
