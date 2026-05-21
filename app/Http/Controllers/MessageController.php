<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MessageController extends Controller
{
    use AuthorizesRequests;

    /**
     * Send a new message in a chat.
     */
    public function store(Request $request, Chat $chat)
    {
        $this->authorize('sendMessage', $chat);

        $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'body'      => $request->body,
        ]);

        // Update the chat's last_message_at for ordering
        $chat->update(['last_message_at' => now()]);

        // Broadcast to WebSocket via queue
        broadcast(new MessageSent($message))->toOthers();

        // If AJAX request, return JSON
        if ($request->expectsJson()) {
            $message->load('sender');

            return response()->json([
                'id'              => $message->id,
                'chat_id'         => $message->chat_id,
                'sender_id'       => $message->sender_id,
                'sender_name'     => $message->sender->getDisplayName(),
                'sender_avatar'   => $message->sender->getAvatarUrl(),
                'body'            => $message->body,
                'created_at'      => $message->created_at->format('H:i'),
                'created_at_full' => $message->created_at->toIso8601String(),
            ]);
        }

        return back();
    }
}
