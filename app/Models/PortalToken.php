<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortalToken extends Model
{
    protected $fillable = [
        'token',
        'user_id',
        'portal_target',
        'user_data',
        'expires_at',
        'used',
        'used_at'
    ];

    protected $casts = [
        'user_data' => 'array',
        'expires_at' => 'datetime',
        'used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isValid(): bool
    {
        return !$this->used
            && $this->expires_at->isFuture();
    }

    public function markAsUsed(): void
    {
        $this->update([
            'used' => true,
            'used_at' => now()
        ]);
    }
}
