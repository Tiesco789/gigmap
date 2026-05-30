<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChatController extends Controller
{
    use AuthorizesRequests;

    /**
     * List all chats for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();

        $chats = Chat::forUser($user->id)
            ->orderedByLatest()
            ->with(['musician', 'establishment', 'latestMessage'])
            ->get()
            ->map(function (Chat $chat) use ($user) {
                $chat->other_participant = $chat->getOtherParticipant($user);
                $chat->unread_count = $chat->unreadCountFor($user);
                return $chat;
            });

        return view('chat.index', compact('chats'));
    }

    /**
     * Create or retrieve an existing chat with a recipient.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();
        $recipient = User::findOrFail($request->recipient_id);

        // Não pode conversar consigo mesmo
        if ($user->id === $recipient->id) {
            return back()->with('error', 'Você não pode iniciar um chat consigo mesmo.');
        }

        // Garantir que são tipos opostos (musician ↔ establishment)
        if ($user->type === $recipient->type) {
            return back()->with('error', 'O chat só pode ser entre um músico e um estabelecimento.');
        }

        // Determinar quem é musician e quem é establishment
        $musicianId = $user->isMusician() ? $user->id : $recipient->id;
        $establishmentId = $user->isEstablishment() ? $user->id : $recipient->id;

        // firstOrCreate garante unicidade
        $chat = Chat::firstOrCreate(
            [
                'musician_id' => $musicianId,
                'establishment_id' => $establishmentId,
            ]
        );

        return redirect()->route('chats.show', $chat);
    }

    /**
     * Show a specific chat conversation.
     */
    public function show(Chat $chat)
    {
        $this->authorize('view', $chat);

        $user = Auth::user();
        $otherParticipant = $chat->getOtherParticipant($user);

        // Load messages with sender and proposal data (oldest first)
        $messages = $chat->messages()
            ->with(['sender', 'proposal'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn ($msg) => $this->formatMessage($msg));

        // Mark unread messages from the other participant as read
        $chat->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('chat.show', [
            'chat'             => $chat,
            'messages'         => $messages,
            'otherParticipant' => $otherParticipant,
            'currentUserId'    => $user->id,
        ]);
    }

    /**
     * Return messages newer than the given ID (for polling fallback).
     */
    public function newMessages(Request $request, Chat $chat)
    {
        $this->authorize('view', $chat);

        $user = Auth::user();
        $afterId = (int) $request->query('after', 0);

        $newMessages = $chat->messages()
            ->with(['sender', 'proposal'])
            ->where('id', '>', $afterId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn ($msg) => $this->formatMessage($msg));

        // Mark incoming unread messages as read
        if ($newMessages->isNotEmpty()) {
            $chat->messages()
                ->where('sender_id', '!=', $user->id)
                ->where('id', '>', $afterId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return response()->json($newMessages);
    }

    // ── Private helpers ──────────────────────────────

    /**
     * Format a message for the frontend (JSON/Blade).
     */
    private function formatMessage($msg): array
    {
        $data = [
            'id'              => $msg->id,
            'chat_id'         => $msg->chat_id,
            'sender_id'       => $msg->sender_id,
            'sender_name'     => $msg->sender->getDisplayName(),
            'sender_avatar'   => $msg->sender->getAvatarUrl(),
            'body'            => $msg->body,
            'type'            => $msg->type ?? 'text',
            'created_at'      => $msg->created_at->setTimezone('America/Sao_Paulo')->format('H:i'),
            'created_at_full' => $msg->created_at->toIso8601String(),
        ];

        // Include proposal data when message is a proposal
        if ($msg->type === 'proposal' && $msg->proposal) {
            $data['proposal'] = [
                'id'              => $msg->proposal->id,
                'value'           => $msg->proposal->value,
                'formatted_value' => $msg->proposal->getFormattedValue(),
                'status'          => $msg->proposal->status,
                'sender_id'       => $msg->proposal->sender_id,
                'sender_name'     => $msg->proposal->sender->getDisplayName(),
                'announcement_title' => $msg->proposal->announcement->title ?? '',
                'accept_url'      => route('proposals.accept', $msg->proposal->id),
                'reject_url'      => route('proposals.reject', $msg->proposal->id),
            ];
        }

        return $data;
    }
}
