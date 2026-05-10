@extends(auth()->check() ? 'layouts.app' : 'layouts.guest')

@section('title', $user->getDisplayName() . ' – Perfil')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10 animate-fade-in-up">

    {{-- Header Card --}}
    <div class="text-center mb-8 p-6 sm:p-10 rounded-lg" style="background:linear-gradient(135deg,#1a1a1a 0%,#111 100%);border:1px solid #2a2a2a;">
        {{-- Avatar --}}
        <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto rounded-full overflow-hidden mb-4" style="border:3px solid #F59E0B;">
            @if($user->avatar)
                <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->getDisplayName() }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center" style="background:#2a2a2a;">
                    <svg class="w-12 h-12" style="color:#F59E0B;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                </div>
            @endif
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold" style="color:#F59E0B;">{{ $user->getDisplayName() }}</h1>

        <p class="text-sm mt-1" style="color:#9CA3AF;">
            {{ $user->isMusician() ? 'Músico' : 'Estabelecimento' }}
            @php
                $profile = $user->isMusician() ? $user->musicianProfile : $user->establishmentProfile;
            @endphp
            @if($profile?->city || $profile?->state)
                · {{ $profile->city }}{{ $profile->city && $profile->state ? ', ' : '' }}{{ $profile->state }}
            @endif
        </p>

        {{-- Share button --}}
        <button id="shareBtn" class="btn-outline-gold text-xs mt-4" style="padding:0.35rem 0.9rem;">
            <svg class="w-3.5 h-3.5 inline -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
            </svg>
            Compartilhar Perfil
        </button>
        <span id="shareMsg" class="text-xs ml-2 hidden" style="color:#22c55e;">Link copiado!</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Left column --}}
        <div class="md:col-span-1 space-y-6">
            {{-- Bio --}}
            @if($profile?->about)
            <div class="p-5 rounded-lg" style="background:#1a1a1a;border:1px solid #2a2a2a;">
                <h3 class="text-sm font-bold mb-2" style="color:#F59E0B;">Sobre</h3>
                <p class="text-sm leading-relaxed" style="color:#d1d5db;">{{ $profile->about }}</p>
            </div>
            @endif

            {{-- Social Links --}}
            @if($user->social_links && count($user->social_links) > 0)
            <div class="p-5 rounded-lg" style="background:#1a1a1a;border:1px solid #2a2a2a;">
                <h3 class="text-sm font-bold mb-3" style="color:#F59E0B;">Links</h3>
                <div class="space-y-2">
                    @foreach($user->social_links as $platform => $url)
                        @if($url)
                        @php
                            $labels = ['instagram'=>'Instagram','spotify'=>'Spotify','youtube'=>'YouTube','website'=>'Site','linktree'=>'Linktree','other'=>'Link'];
                            $colors = ['instagram'=>'#E1306C','spotify'=>'#1DB954','youtube'=>'#FF0000','website'=>'#F59E0B','linktree'=>'#43E660','other'=>'#9CA3AF'];
                        @endphp
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-md text-sm font-medium transition-all hover:scale-[1.02]"
                            style="background:#222;border:1px solid {{ $colors[$platform] ?? '#555' }};color:{{ $colors[$platform] ?? '#ccc' }};">
                            <span class="w-5 text-center">
                                @if($platform === 'instagram')♦@elseif($platform === 'spotify')♫@elseif($platform === 'youtube')▶@elseif($platform === 'website')🌐@elseif($platform === 'linktree')🔗@else+@endif
                            </span>
                            {{ $labels[$platform] ?? ucfirst($platform) }}
                            <svg class="w-3.5 h-3.5 ml-auto opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Info --}}
            @if($user->isEstablishment() && $user->establishmentProfile)
            <div class="p-5 rounded-lg" style="background:#1a1a1a;border:1px solid #2a2a2a;">
                <h3 class="text-sm font-bold mb-2" style="color:#F59E0B;">Informações</h3>
                <div class="space-y-2 text-sm" style="color:#d1d5db;">
                    @if($user->establishmentProfile->cnpj)
                    <p><span style="color:#9CA3AF;">CNPJ:</span> {{ $user->establishmentProfile->cnpj }}</p>
                    @endif
                    @if($user->establishmentProfile->website)
                    <p><span style="color:#9CA3AF;">Website:</span> <a href="{{ $user->establishmentProfile->website }}" target="_blank" class="hover:underline" style="color:#F59E0B;">{{ $user->establishmentProfile->website }}</a></p>
                    @endif
                    @if($user->establishmentProfile->address)
                    <p><span style="color:#9CA3AF;">Endereço:</span> {{ $user->establishmentProfile->address }}{{ $user->establishmentProfile->number ? ', '.$user->establishmentProfile->number : '' }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Right column --}}
        <div class="md:col-span-2 space-y-6">
            {{-- Announcements --}}
            @if($user->announcements->count() > 0)
            <div>
                <h3 class="text-lg font-bold mb-4" style="color:#F59E0B;">Anúncios ({{ $user->announcements->count() }})</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($user->announcements->take(6) as $ad)
                    <a href="{{ auth()->check() ? route('announcements.show', $ad) : route('login') }}" class="card-announcement block">
                        <div class="aspect-[4/3] overflow-hidden" style="background:#2a2a2a;">
                            <img src="{{ $ad->getImageUrl() }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-3">
                            <h4 class="text-sm font-bold truncate" style="color:#F5F5DC;">{{ $ad->title }}</h4>
                            <p class="text-xs mt-1" style="color:#9CA3AF;">{{ $ad->getFormattedPrice() }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Reviews --}}
            @if($user->reviewsReceived->count() > 0)
            <div>
                <h3 class="text-lg font-bold mb-4" style="color:#F59E0B;">Avaliações ({{ $user->reviewsReceived->count() }})</h3>
                <div class="space-y-4">
                    @foreach($user->reviewsReceived->take(5) as $review)
                    <div class="p-4 rounded-lg" style="background:#1a1a1a;border:1px solid #2a2a2a;">
                        <p class="text-xs font-semibold mb-1" style="color:#F59E0B;">{{ $review->reviewer->getDisplayName() }}</p>
                        <p class="text-sm" style="color:#d1d5db;">{{ $review->description }}</p>
                        <p class="text-xs mt-2" style="color:#666;">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($user->announcements->count() === 0 && $user->reviewsReceived->count() === 0)
            <div class="text-center py-16" style="color:#9CA3AF;">
                <p class="text-sm">Este perfil ainda não possui anúncios ou avaliações.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('shareBtn')?.addEventListener('click', () => {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const msg = document.getElementById('shareMsg');
        msg?.classList.remove('hidden');
        setTimeout(() => msg?.classList.add('hidden'), 2000);
    });
});
</script>
@endpush
