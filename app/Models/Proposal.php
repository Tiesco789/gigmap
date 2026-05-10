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
        'status',
    ];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
