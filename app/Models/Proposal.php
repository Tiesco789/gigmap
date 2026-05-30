<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    protected $fillable = [
        'announcement_id',
        'sender_id',
        'message',
        'value',
        'chat_id',
        'status',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    // ── Status Helpers ────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    // ── Formatting ────────────────────────────────────

    /**
     * Returns the formatted value: "R$1.500,00" or "A negociar".
     */
    public function getFormattedValue(): string
    {
        if ($this->value !== null && $this->value > 0) {
            return 'R$' . number_format((float) $this->value, 2, ',', '.');
        }

        return 'A negociar';
    }
}
