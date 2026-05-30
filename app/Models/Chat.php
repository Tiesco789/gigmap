<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Chat extends Model
{
    protected $fillable = [
        'musician_id',
        'establishment_id',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    // ── Relationships ─────────────────────────────────

    public function musician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'musician_id');
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(User::class, 'establishment_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    // ── Scopes ────────────────────────────────────────

    /**
     * Filter chats where the given user is a participant.
     */
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('musician_id', $userId)
                     ->orWhere('establishment_id', $userId);
    }

    /**
     * Order by most recent message first.
     */
    public function scopeOrderedByLatest(Builder $query): Builder
    {
        return $query->orderByDesc('last_message_at');
    }

    // ── Helpers ───────────────────────────────────────

    /**
     * Get the other participant in this chat.
     */
    public function getOtherParticipant(User $user): User
    {
        return $user->id === $this->musician_id
            ? $this->establishment
            : $this->musician;
    }

    /**
     * Check if a user is a participant of this chat.
     */
    public function hasParticipant(User $user): bool
    {
        return $user->id === $this->musician_id || $user->id === $this->establishment_id;
    }

    /**
     * Count unread messages for a given user (messages sent by the OTHER participant).
     */
    public function unreadCountFor(User $user): int
    {
        return $this->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->count();
    }
}
