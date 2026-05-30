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
            <div>
                {{-- Regular text message --}}
                <template x-if="msg.type !== 'proposal'">
                    <div class="chat-bubble-wrapper"
                         :class="msg.sender_id == currentUserId ? 'sent' : 'received'">
                        <div class="chat-bubble"
                             :class="msg.sender_id == currentUserId ? 'bubble-sent' : 'bubble-received'">
                            <p class="chat-bubble-body" x-text="msg.body"></p>
                            <span class="chat-bubble-time" x-text="msg.created_at"></span>
                        </div>
                    </div>
                </template>

                {{-- Proposal message card --}}
                <template x-if="msg.type === 'proposal' && msg.proposal">
                    <div class="proposal-card-wrapper">
                        <div class="proposal-card"
                             :class="{
                                 'proposal-card-pending': msg.proposal.status === 'pending',
                                 'proposal-card-accepted': msg.proposal.status === 'accepted',
                                 'proposal-card-rejected': msg.proposal.status === 'rejected'
                             }">
                            {{-- Header --}}
                            <div class="proposal-card-header">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-sm font-bold">Proposta</span>
                                <span class="proposal-status-badge"
                                      :class="{
                                          'badge-pending': msg.proposal.status === 'pending',
                                          'badge-accepted': msg.proposal.status === 'accepted',
                                          'badge-rejected': msg.proposal.status === 'rejected'
                                      }"
                                      x-text="msg.proposal.status === 'pending' ? 'Pendente' : msg.proposal.status === 'accepted' ? 'Aceita ✓' : 'Recusada ✗'">
                                </span>
                            </div>

                            {{-- Value --}}
                            <div class="proposal-value" x-text="msg.proposal.formatted_value"></div>

                            {{-- Meta --}}
                            <div class="proposal-meta">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#6B7280;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span x-text="msg.proposal.sender_name"></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#6B7280;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span x-text="msg.created_at"></span>
                                </div>
                            </div>

                            {{-- Announcement reference --}}
                            <div class="proposal-announcement" x-show="msg.proposal.announcement_title" x-cloak>
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#6B7280;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <span class="text-xs truncate" x-text="msg.proposal.announcement_title" style="color:#9CA3AF;"></span>
                            </div>

                            {{-- Actions (only for the recipient when pending) --}}
                            <div class="proposal-actions"
                                 x-show="msg.proposal.status === 'pending' && msg.proposal.sender_id != currentUserId"
                                 x-cloak>
                                <button type="button" class="proposal-btn-accept"
                                        x-on:click="respondProposal(msg, 'accept')"
                                        :disabled="!!msg._responding">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Aceitar
                                </button>
                                <button type="button" class="proposal-btn-reject"
                                        x-on:click="respondProposal(msg, 'reject')"
                                        :disabled="!!msg._responding">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Recusar
                                </button>
                            </div>

                            {{-- Waiting indicator for sender --}}
                            <div class="proposal-waiting"
                                 x-show="msg.proposal.status === 'pending' && msg.proposal.sender_id == currentUserId"
                                 x-cloak>
                                <div class="proposal-waiting-dot"></div>
                                Aguardando resposta...
                            </div>
                        </div>
                    </div>
                </template>
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
            // Garante que o estado _responding esteja inicializado como false
            this.messages.forEach(m => {
                m._responding = false;
            });

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

                        e._responding = false;
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
                            msg._responding = false;
                            this.messages.push(msg);
                            hasNew = true;
                        }
                    });

                    // Also refresh proposal statuses in existing messages
                    this.refreshProposalStatuses(newMessages);

                    if (hasNew) {
                        this.$nextTick(() => this.scrollToBottom());
                    }
                }
            } catch (err) {
                // Silently ignore polling errors
            }
        },

        /**
         * Update proposal statuses from polled messages (in case other user accepted/rejected).
         */
        refreshProposalStatuses(newMessages) {
            // Check if any existing proposal messages need status updates
            newMessages.forEach(newMsg => {
                if (newMsg.type === 'proposal' && newMsg.proposal) {
                    const existing = this.messages.find(m =>
                        m.type === 'proposal' &&
                        m.proposal &&
                        m.proposal.id === newMsg.proposal.id
                    );
                    if (existing && existing.proposal.status !== newMsg.proposal.status) {
                        existing.proposal.status = newMsg.proposal.status;
                    }
                }
            });
        },

        /**
         * Handle Accept / Reject proposal via AJAX.
         */
        async respondProposal(msg, action) {
            if (msg._responding) return;
            msg._responding = true;

            const url = action === 'accept'
                ? msg.proposal.accept_url
                : msg.proposal.reject_url;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (response.ok) {
                    const data = await response.json();
                    // Update the proposal status optimistically
                    msg.proposal.status = data.status;
                } else {
                    const errData = await response.json().catch(() => ({}));
                    alert(errData.message || 'Erro ao processar proposta.');
                }
            } catch (err) {
                alert('Erro de conexão. Tente novamente.');
            } finally {
                msg._responding = false;
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
                type: 'text',
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
