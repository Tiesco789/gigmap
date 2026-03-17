@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 animate-fade-in-up">

    <h1 class="text-xl font-bold mb-1" style="color:#F59E0B;">
        {{ $user->isMusician() ? 'Conta' : 'Conta' }}
    </h1>
    <p class="text-sm mb-6" style="color:#9CA3AF;">Aqui você ajusta seu perfil</p>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Photo --}}
        <div class="form-section">
            <div class="form-section-label">Foto</div>
            <div class="flex items-center gap-4">
                <div id="avatarPreview" class="w-16 h-16 rounded-full overflow-hidden flex items-center justify-center" style="background:#2a2a2a;border:2px solid #333;">
                    @if($user->avatar)
                        <img src="{{ $user->getAvatarUrl() }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <svg class="w-8 h-8" style="color:#555;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    @endif
                </div>
                <button type="button" class="btn-outline-gold text-sm" style="padding:0.4rem 1rem;" onclick="document.getElementById('avatarInput').click()">
                    Upload photo
                </button>
                <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*">
            </div>
        </div>

        @if($user->isMusician())
        {{-- Musician fields --}}
        <div class="form-section">
            <div class="form-section-label">Nome / Sobrenome</div>
            <div class="space-y-3">
                <input type="text" name="first_name" value="{{ old('first_name', $user->musicianProfile?->first_name) }}"
                    placeholder="Nome" class="input-subtle">
                <input type="text" name="last_name" value="{{ old('last_name', $user->musicianProfile?->last_name) }}"
                    placeholder="Sobrenome" class="input-subtle">
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-label">Email address</div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2">
                    <svg class="w-4 h-4" style="color:#F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="email@example.com"
                    class="input-subtle pl-9" required>
            </div>
            @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-section">
            <div class="form-section-label">About</div>
            <div>
                <textarea name="about" rows="5" id="aboutTextarea" maxlength="500"
                    placeholder="Type your message..."
                    class="input-subtle resize-none w-full">{{ old('about', $user->musicianProfile?->about) }}</textarea>
                <p class="text-xs mt-1" style="color:#9CA3AF;"><span id="charCount">{{ strlen($user->musicianProfile?->about ?? '') }}</span>/500 caracteres</p>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-label">Estado / Cidade / CEP / Endereço</div>
            <div class="space-y-3">
                <select name="state" class="input-subtle">
                    <option value="">Selecione ...</option>
                    @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                        <option value="{{ $uf }}" {{ old('state', $user->musicianProfile?->state) === $uf ? 'selected' : '' }}>{{ $uf }}</option>
                    @endforeach
                </select>
                <input type="text" name="city" value="{{ old('city', $user->musicianProfile?->city) }}" placeholder="Cidade" class="input-subtle">
                <input type="text" name="cep" value="{{ old('cep', $user->musicianProfile?->cep) }}" placeholder="CEP" class="input-subtle">
                <input type="text" name="address" value="{{ old('address', $user->musicianProfile?->address) }}" placeholder="Endereço" class="input-subtle">
            </div>
        </div>

        @else
        {{-- Establishment fields --}}
        <div class="form-section">
            <div class="form-section-label">Nome do estabelecimento</div>
            <input type="text" name="establishment_name" value="{{ old('establishment_name', $user->establishmentProfile?->establishment_name) }}"
                class="input-subtle">
        </div>

        <div class="form-section">
            <div class="form-section-label">CNPJ</div>
            <input type="text" name="cnpj" value="{{ old('cnpj', $user->establishmentProfile?->cnpj) }}"
                placeholder="00.000.000/0000-00" class="input-subtle">
        </div>

        <div class="form-section">
            <div class="form-section-label">Website</div>
            <div class="flex">
                <span class="input-subtle" style="width:auto;border-right:none;border-radius:0.25rem 0 0 0.25rem;color:#9CA3AF;white-space:nowrap;flex-shrink:0;">http://</span>
                <input type="text" name="website" value="{{ old('website', $user->establishmentProfile?->website) }}"
                    placeholder="www.exemplo.com.br" class="input-subtle" style="border-radius:0 0.25rem 0.25rem 0;">
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-label">Email address</div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2">
                    <svg class="w-4 h-4" style="color:#F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    placeholder="email@example.com" class="input-subtle pl-9" required>
            </div>
            @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-section">
            <div class="form-section-label">About</div>
            <textarea name="about" rows="5" id="aboutTextarea" maxlength="500"
                placeholder="Type your message..."
                class="input-subtle resize-none w-full">{{ old('about', $user->establishmentProfile?->about) }}</textarea>
        </div>

        <div class="form-section">
            <div class="form-section-label">Estado / Cidade / CEP / Endereço</div>
            <div class="space-y-3">
                <select name="state" class="input-subtle">
                    <option value="">Selecione ...</option>
                    @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                        <option value="{{ $uf }}" {{ old('state', $user->establishmentProfile?->state) === $uf ? 'selected' : '' }}>{{ $uf }}</option>
                    @endforeach
                </select>
                <input type="text" name="city" value="{{ old('city', $user->establishmentProfile?->city) }}" placeholder="Cidade" class="input-subtle">
                <input type="text" name="cep" value="{{ old('cep', $user->establishmentProfile?->cep) }}" placeholder="CEP" class="input-subtle">
                <input type="text" name="address" value="{{ old('address', $user->establishmentProfile?->address) }}" placeholder="Endereço" class="input-subtle">
            </div>
        </div>
        @endif

        {{-- Password --}}
        <div class="form-section">
            <div class="form-section-label">Password</div>
            <div class="space-y-3">
                <div class="relative">
                    <input type="password" name="current_password" placeholder="Current password" class="input-subtle pr-10">
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2" style="color:#F59E0B;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <div class="relative">
                    <input type="password" name="new_password" placeholder="New password" class="input-subtle pr-10">
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2" style="color:#F59E0B;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <input type="password" name="new_password_confirmation" placeholder="Confirm new password" class="input-subtle">
            </div>
            @error('current_password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            @error('new_password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Recomendações (read-only) --}}
        @if($user->reviewsReceived->count() > 0)
        <div class="form-section">
            <div class="form-section-label">Recomendações</div>
            <div class="space-y-4">
                @foreach($user->reviewsReceived()->with('reviewer')->latest()->take(5)->get() as $review)
                <div class="border-b pb-4" style="border-color:#2a2a2a;">
                    <p class="text-xs mb-1" style="color:#F59E0B;">
                        {{ $review->reviewer->getDisplayName() }}
                        @if($review->reviewer->musicianProfile?->city || $review->reviewer->establishmentProfile?->city)
                            , {{ $review->reviewer->musicianProfile?->city ?? $review->reviewer->establishmentProfile?->city }}
                            – {{ $review->reviewer->musicianProfile?->state ?? $review->reviewer->establishmentProfile?->state }}
                        @endif
                    </p>
                    <p class="text-sm" style="color:#d1d5db;">{{ $review->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Actions --}}
        <div class="flex justify-end gap-3 mt-6 pt-4" style="border-top:1px solid #2a2a2a;">
            <a href="{{ route('announcements.index') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
const textarea = document.getElementById('aboutTextarea');
const charCount = document.getElementById('charCount');
if (textarea && charCount) {
    textarea.addEventListener('input', () => {
        charCount.textContent = textarea.value.length;
    });
}

// Avatar preview
document.getElementById('avatarInput')?.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('avatarPreview');
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
