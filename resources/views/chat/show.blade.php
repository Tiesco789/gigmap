@extends('layouts.app')

@section('title', 'Chat com ' . $otherParticipant->getDisplayName())

@section('content')
<div class="chat-container" x-data="chatApp()" x-init="init()">

    {{-- Chat header --}}
    <div class="chat-header">
        <a href="{{ route('chats.index') }}" class="chat-back-btn" title="Voltar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <a href="{{ route('profile.show', $otherParticipant->id) }}" class="chat-header-user">
            <img src="{{ $otherParticipant->getAvatarUrl() }}"
                 alt="{{ $otherParticipant->getDisplayName() }}"
                 class="chat-header-avatar"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="chat-header-avatar-fallback" style="display:none;">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" style="color:#F59E0B;">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>
            <div>
                <span class="chat-header-name">{{ $otherParticipant->getDisplayName() }}</span>
                <span class="chat-header-type {{ $otherParticipant->isMusician() ? 'type-musician' : 'type-establishment' }}">
                    {{ $otherParticipant->isMusician() ? 'Músico' : 'Estabelecimento' }}
                </span>
            </div>
        </a>
    </div>

    {{-- Messages area --}}
    <div class="chat-messages" id="chatMessages" x-ref="messagesContainer">

        {{-- Empty state --}}
        <template x-if="messages.length === 0">
            <div class="chat-messages-empty">
                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#333;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p class="text-sm" style="color:#6B7280;">Comece a conversa enviando uma mensagem!</p>
            </div>
        </template>

        {{-- Message bubbles --}}
        <template x-for="msg in messages" :key="msg.id">
            <div class="chat-bubble-wrapper"
                 :class="msg.sender_id == currentUserId ? 'sent' : 'received'">
                <div class="chat-bubble"
                     :class="msg.sender_id == currentUserId ? 'bubble-sent' : 'bubble-received'">
                    <p class="chat-bubble-body" x-text="msg.body"></p>
                    <span class="chat-bubble-time" x-text="msg.created_at"></span>
                </div>
            </div>
        </template>
    </div>

    {{-- Input area --}}
    <div class="chat-input-area">
        <form @submit.prevent="sendMessage()" class="chat-input-form">
            @csrf
            <input type="text"
                   x-model="newMessage"
                   placeholder="Digite sua mensagem..."
                   class="chat-input"
                   id="chatInput"
                   maxlength="5000"
                   autocomplete="off"
                   :disabled="sending">
            <button type="submit"
                    class="chat-send-btn"
                    :disabled="!newMessage.trim() || sending"
                    :class="{ 'opacity-50 cursor-not-allowed': !newMessage.trim() || sending }">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>
    </div>

</div>

@push('scripts')
<script>
function chatApp() {
    return {
        messages: @json($messages),
        newMessage: '',
        sending: false,
        currentUserId: {{ $currentUserId }},
        chatId: {{ $chat->id }},
        csrfToken: '{{ csrf_token() }}',
        pollingInterval: null,
        echoConnected: false,

        init() {
            this.$nextTick(() => this.scrollToBottom());

            // Try Echo (Reverb WebSocket) first
            if (window.Echo) {
                try {
                    const channel = window.Echo.private(`chat.${this.chatId}`);
                    channel.listen('MessageSent', (e) => {
                        // Avoid duplicating own messages
                        if (e.sender_id == this.currentUserId) return;
                        // Avoid duplicating messages already in the list
                        if (this.messages.some(m => m.id === e.id)) return;

                        this.messages.push(e);
                        this.$nextTick(() => this.scrollToBottom());
                    });

                    // Check if Echo/Pusher connects within 3 seconds
                    const pusherConn = window.Echo.connector?.pusher?.connection;
                    if (pusherConn) {
                        pusherConn.bind('connected', () => {
                            this.echoConnected = true;
                            this.stopPolling();
                        });
                        pusherConn.bind('disconnected', () => {
                            this.echoConnected = false;
                            this.startPolling();
                        });
                    }

                    // Start polling as fallback — will stop if Echo connects
                    setTimeout(() => {
                        if (!this.echoConnected) {
                            this.startPolling();
                        }
                    }, 3000);
                } catch (err) {
                    // Echo failed to initialize, fall back to polling
                    this.startPolling();
                }
            } else {
                // No Echo available, use polling
                this.startPolling();
            }
        },

        /**
         * Get the current time formatted in Brasília timezone (HH:mm).
         */
        getBrasiliaTime() {
            return new Intl.DateTimeFormat('pt-BR', {
                hour: '2-digit',
                minute: '2-digit',
                timeZone: 'America/Sao_Paulo',
                hour12: false,
            }).format(new Date());
        },

        /**
         * Get the highest message ID for polling.
         */
        getLastMessageId() {
            for (let i = this.messages.length - 1; i >= 0; i--) {
                const id = this.messages[i].id;
                if (typeof id === 'number') return id;
            }
            return 0;
        },

        /**
         * Start polling for new messages every 3 seconds.
         */
        startPolling() {
            if (this.pollingInterval) return;
            this.pollingInterval = setInterval(() => this.pollMessages(), 3000);
        },

        stopPolling() {
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
                this.pollingInterval = null;
            }
        },

        async pollMessages() {
            try {
                const lastId = this.getLastMessageId();
                const response = await fetch(`/chat/${this.chatId}/novas-mensagens?after=${lastId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (response.ok) {
                    const newMessages = await response.json();
                    let hasNew = false;

                    newMessages.forEach(msg => {
                        // Skip own messages (already added optimistically)
                        if (msg.sender_id == this.currentUserId) {
                            // But replace temp messages with real ones
                            const tempIdx = this.messages.findIndex(m =>
                                String(m.id).startsWith('temp-') && m.sender_id == this.currentUserId
                            );
                            if (tempIdx !== -1) {
                                this.messages[tempIdx] = msg;
                            }
                            return;
                        }

                        // Avoid duplicates
                        if (!this.messages.some(m => m.id === msg.id)) {
                            this.messages.push(msg);
                            hasNew = true;
                        }
                    });

                    if (hasNew) {
                        this.$nextTick(() => this.scrollToBottom());
                    }
                }
            } catch (err) {
                // Silently ignore polling errors
            }
        },

        async sendMessage() {
            const body = this.newMessage.trim();
            if (!body || this.sending) return;

            this.sending = true;

            // Optimistic append with Brasília time
            const tempId = 'temp-' + Date.now();
            const optimisticMsg = {
                id: tempId,
                chat_id: this.chatId,
                sender_id: this.currentUserId,
                body: body,
                created_at: this.getBrasiliaTime(),
            };
            this.messages.push(optimisticMsg);
            this.newMessage = '';
            this.$nextTick(() => this.scrollToBottom());

            try {
                const response = await fetch(`/chat/${this.chatId}/mensagens`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ body: body }),
                });

                if (response.ok) {
                    const data = await response.json();
                    // Replace optimistic message with real one
                    const idx = this.messages.findIndex(m => m.id === tempId);
                    if (idx !== -1) {
                        this.messages[idx] = data;
                    }
                } else {
                    // Remove optimistic message on failure
                    this.messages = this.messages.filter(m => m.id !== tempId);
                    this.newMessage = body; // restore
                }
            } catch (err) {
                this.messages = this.messages.filter(m => m.id !== tempId);
                this.newMessage = body;
            } finally {
                this.sending = false;
                this.$nextTick(() => {
                    document.getElementById('chatInput')?.focus();
                });
            }
        },

        scrollToBottom() {
            const container = this.$refs.messagesContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
    };
}
</script>
@endpush
@endsection
