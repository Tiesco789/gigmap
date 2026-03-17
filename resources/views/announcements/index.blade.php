@extends('layouts.app')

@section('title', 'Anúncios')
@section('meta_description', 'A plataforma onde artistas encontram palco e palcos encontram artista. Simplifique sua busca por shows, eventos e músicos qualificados.')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-14 animate-fade-in-up">

    {{-- Hero header --}}
    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-3" style="color:#F59E0B;">
            A plataforma onde artistas encontram<br>palco e palcos encontram artista
        </h1>
        <p class="text-base" style="color:#9CA3AF;">Simplifique sua busca por shows, eventos e músicos qualificados.</p>
    </div>

    {{-- Genre filter tabs --}}
    <div class="flex items-center justify-center flex-wrap gap-2 mb-10">
        <a href="{{ route('announcements.index') }}"
            class="genre-pill {{ !request('genre') || request('genre') === 'all' ? 'active' : '' }}">
            View all
        </a>
        @foreach($genres as $g)
        <a href="{{ route('announcements.index', ['genre' => $g]) }}"
            class="genre-pill {{ request('genre') === $g ? 'active' : '' }}">
            {{ $g }}
        </a>
        @endforeach
    </div>

    {{-- Create button (auth only) --}}
    @auth
    <div class="flex justify-end mb-6">
        <a href="{{ route('announcements.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Criar Anúncio
        </a>
    </div>
    @endauth

    {{-- Grid --}}
    @if($announcements->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($announcements as $ad)
        <article class="card-announcement animate-fade-in-up" style="animation-delay: {{ $loop->iteration * 0.05 }}s;">
            {{-- Image --}}
            <div class="aspect-[4/3] overflow-hidden" style="background:#2a2a2a;">
                @if($ad->image)
                    <img src="{{ $ad->getImageUrl() }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-12 h-12" style="color:#444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="p-4">
                <p class="text-xs font-bold mb-1" style="color:#F59E0B;">{{ $ad->getFormattedPrice() }}</p>
                <h2 class="text-base font-bold mb-2 leading-tight">{{ $ad->title }}</h2>
                <p class="text-sm leading-relaxed line-clamp-3 mb-4" style="color:#9CA3AF;">{{ $ad->description }}</p>
                <a href="{{ route('announcements.show', $ad) }}" class="inline-flex items-center gap-1 text-sm font-semibold" style="color:#F59E0B;">
                    Ver Anúncio
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </article>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $announcements->links() }}
    </div>

    @else
    <div class="text-center py-20">
        <svg class="w-16 h-16 mx-auto mb-4" style="color:#333;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-lg font-semibold mb-2">Nenhum anúncio encontrado</p>
        <p class="text-sm" style="color:#9CA3AF;">
            @if(request('genre'))
                Nenhum anúncio na categoria "{{ request('genre') }}".
                <a href="{{ route('announcements.index') }}" style="color:#F59E0B;">Ver todos</a>
            @else
                Seja o primeiro a criar um anúncio!
            @endif
        </p>
        @auth
        <a href="{{ route('announcements.create') }}" class="btn-primary mt-4 inline-flex">
            Criar Anúncio
        </a>
        @endauth
    </div>
    @endif
</div>
@endsection
