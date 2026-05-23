<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Message $message)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->chat_id),
        ];
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith(): array
    {
        $this->message->load('sender');

        return [
            'id'             => $this->message->id,
            'chat_id'        => $this->message->chat_id,
            'sender_id'      => $this->message->sender_id,
            'sender_name'    => $this->message->sender->getDisplayName(),
            'sender_avatar'  => $this->message->sender->getAvatarUrl(),
            'body'           => $this->message->body,
            'created_at'     => $this->message->created_at->setTimezone('America/Sao_Paulo')->format('H:i'),
            'created_at_full' => $this->message->created_at->toIso8601String(),
        ];
    }
}
