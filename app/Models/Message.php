<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_id',
        'body',
        'type',
        'proposal_id',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    // ── Relationships ─────────────────────────────────

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    // ── Helpers ───────────────────────────────────────

    /**
     * Check if this message is a proposal card.
     */
    public function isProposal(): bool
    {
        return $this->type === 'proposal';
    }

    // ── Scopes ────────────────────────────────────────

    /**
     * Filter only unread messages.
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }
}
