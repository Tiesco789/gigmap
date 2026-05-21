<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;

class ChatPolicy
{
    /**
     * Can the user view this chat?
     */
    public function view(User $user, Chat $chat): bool
    {
        return $chat->hasParticipant($user);
    }

    /**
     * Can the user send a message in this chat?
     */
    public function sendMessage(User $user, Chat $chat): bool
    {
        return $chat->hasParticipant($user);
    }
}
