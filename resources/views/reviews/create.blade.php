@extends('layouts.app')

@section('title', 'Avaliar – ' . $user->getDisplayName())

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12 animate-fade-in-up">

    <h1 class="text-2xl font-bold mb-8" style="color:#F59E0B;">Deixe sua recomendação</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Form --}}
        <div class="md:col-span-2">
            <form method="POST" action="{{ route('reviews.store', $user) }}">
                @csrf

                <div class="mb-6">
                    <label class="label-gold mb-2 block">Descrição</label>
                    <textarea name="description" id="reviewTextarea" rows="8" maxlength="1000"
                        placeholder="Digite sua mensagem"
                        class="input-field resize-none w-full" required>{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn-primary">
                    Deixar avaliação
                </button>
            </form>
        </div>

        {{-- Artist info sidebar --}}
        <div>
            <div class="mb-4">
                <p class="text-xs font-semibold mb-1" style="color:#F59E0B;">Nome do Artista</p>
                <p class="font-semibold">{{ $user->getDisplayName() }}</p>
            </div>

            @if($user->announcements->first()?->image)
            <div class="mb-4">
                <p class="text-xs font-semibold mb-2" style="color:#F59E0B;">
                    {{ $user->isMusician() ? 'Logo da Banda' : 'Imagem do Estabelecimento' }}
                </p>
                <img src="{{ $user->announcements->first()->getImageUrl() }}"
                    alt="{{ $user->getDisplayName() }}"
                    class="w-full rounded-lg object-cover" style="max-height:200px;">
            </div>
            @elseif($user->avatar)
            <div class="mb-4">
                <p class="text-xs font-semibold mb-2" style="color:#F59E0B;">Foto de Perfil</p>
                <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->getDisplayName() }}"
                    class="w-24 h-24 rounded-full object-cover border-2 border-amber-500">
            </div>
            @endif

            @if($user->isMusician() && $user->musicianProfile)
            <div class="text-sm space-y-1" style="color:#9CA3AF;">
                @if($user->musicianProfile->city)
                <p>📍 {{ $user->musicianProfile->city }}
                    @if($user->musicianProfile->state) – {{ $user->musicianProfile->state }}@endif
                </p>
                @endif
            </div>
            @elseif($user->isEstablishment() && $user->establishmentProfile)
            <div class="text-sm space-y-1" style="color:#9CA3AF;">
                @if($user->establishmentProfile->city)
                <p>📍 {{ $user->establishmentProfile->city }}
                    @if($user->establishmentProfile->state) – {{ $user->establishmentProfile->state }}@endif
                </p>
                @endif
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
