@extends('layouts.app')

@section('title', 'Minhas Conversas')
@section('meta_description', 'Gerencie suas conversas com músicos e estabelecimentos no GigMap.')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold" style="color:#F59E0B;">Mensagens</h1>
        <span class="text-sm" style="color:#6B7280;">{{ $chats->count() }} conversa{{ $chats->count() !== 1 ? 's' : '' }}</span>
    </div>

    @if($chats->isEmpty())
        {{-- Empty state --}}
        <div class="chat-empty-state">
            <div class="chat-empty-icon">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#333;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold mb-2" style="color:#F5F5DC;">Nenhuma conversa ainda</h2>
            <p class="text-sm mb-6" style="color:#6B7280; max-width:320px; margin:0 auto;">
                Visite o perfil de um músico ou estabelecimento e clique em "Enviar Mensagem" para iniciar uma conversa.
            </p>
            <a href="{{ route('announcements.index') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Explorar Anúncios
            </a>
        </div>
    @else
        {{-- Chat list --}}
        <div class="chat-list">
            @foreach($chats as $chat)
                <a href="{{ route('chats.show', $chat) }}" class="chat-list-item" id="chat-item-{{ $chat->id }}">
                    {{-- Avatar --}}
                    <div class="chat-avatar-wrapper">
                        <img src="{{ $chat->other_participant->getAvatarUrl() }}"
                             alt="{{ $chat->other_participant->getDisplayName() }}"
                             class="chat-avatar"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="chat-avatar-fallback" style="display:none;">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" style="color:#F59E0B;">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Chat info --}}
                    <div class="chat-info">
                        <div class="chat-info-header">
                            <span class="chat-name">{{ $chat->other_participant->getDisplayName() }}</span>
                            <span class="chat-type-badge {{ $chat->other_participant->isMusician() ? 'badge-musician' : 'badge-establishment' }}">
                                {{ $chat->other_participant->isMusician() ? 'Músico' : 'Estabelecimento' }}
                            </span>
                        </div>
                        <p class="chat-preview">
                            @if($chat->latestMessage)
                                @if($chat->latestMessage->sender_id === auth()->id())
                                    <span style="color:#6B7280;">Você: </span>
                                @endif
                                {{ Str::limit($chat->latestMessage->body, 50) }}
                            @else
                                <span style="color:#555;">Nenhuma mensagem ainda</span>
                            @endif
                        </p>
                    </div>

                    {{-- Right side: time + badge --}}
                    <div class="chat-meta">
                        @if($chat->latestMessage)
                            <span class="chat-time">
                                {{ $chat->latestMessage->created_at->diffForHumans(null, true, true) }}
                            </span>
                        @endif
                        @if($chat->unread_count > 0)
                            <span class="chat-unread-badge">
                                {{ $chat->unread_count > 9 ? '9+' : $chat->unread_count }}
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>
@endsection
