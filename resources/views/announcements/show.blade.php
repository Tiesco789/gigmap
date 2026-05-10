@extends('layouts.app')

@section('title', $announcement->title)

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12 animate-fade-in-up">

    {{-- Title + Avaliar button --}}
    <div class="flex items-start justify-between gap-6 mb-8">
        <h1 class="text-3xl font-bold" style="color:#F59E0B;">{{ $announcement->title }}</h1>
        @if(auth()->id() !== $announcement->user_id)
        <a href="{{ route('reviews.create', $announcement->user) }}" class="btn-primary flex-shrink-0">
            Avaliar Artista
        </a>
        @else
        <div class="flex gap-2">
            <a href="{{ route('announcements.edit', $announcement) }}" class="btn-outline-gold flex-shrink-0 text-sm">
                Editar
            </a>
            <form method="POST" action="{{ route('announcements.destroy', $announcement) }}"
                onsubmit="return confirm('Deseja excluir este anúncio?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-outline flex-shrink-0 text-sm" style="color:#ef4444;border-color:#ef4444;">
                    Excluir
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- Meta info --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div>
            <p class="text-xs font-semibold mb-1" style="color:#F59E0B;">Nome do Artista</p>
            <p>{{ $announcement->user->getDisplayName() }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold mb-1" style="color:#F59E0B;">Valor</p>
            <p>{{ $announcement->getFormattedPrice() }}</p>
        </div>
        @if($announcement->location)
        <div>
            <p class="text-xs font-semibold mb-1" style="color:#F59E0B;">Localização</p>
            <p>{{ $announcement->location }}</p>
        </div>
        @endif
    </div>

    {{-- Image + Description --}}
    <div class="flex flex-col md:flex-row gap-10 mb-10">
        <div class="md:w-80 flex-shrink-0">
            <img src="{{ $announcement->getImageUrl() }}" alt="{{ $announcement->title }}"
                class="w-full rounded-lg object-cover" style="max-height:280px;">
        </div>

        <div class="flex-1">
            <p class="text-sm font-semibold mb-2" style="color:#F59E0B;">Descrição</p>
            <p class="text-sm leading-relaxed" style="color:#d1d5db;">{{ $announcement->description }}</p>
        </div>
    </div>

    {{-- Proposal Form --}}
    @if(auth()->id() !== $announcement->user_id)
    <div class="p-6 rounded-lg" style="background:#1a1a1a;border:1px solid #2a2a2a;">
        <h3 class="text-lg font-bold mb-3" style="color:#F59E0B;">Enviar Proposta</h3>
        <form method="POST" action="{{ route('proposals.store', $announcement) }}">
            @csrf
            <div class="mb-4">
                <textarea name="message" rows="4" maxlength="1000"
                    placeholder="Descreva sua proposta, disponibilidade, repertório..."
                    class="input-subtle resize-none w-full">{{ old('message') }}</textarea>
                @error('message')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Enviar Proposta
            </button>
        </form>
    </div>
    @endif

</div>
@endsection
