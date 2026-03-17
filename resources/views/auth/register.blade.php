@extends('layouts.guest')

@section('title', 'Cadastro')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12 animate-fade-in-up">

    {{-- Tabs --}}
    <div class="flex gap-8 mb-8 border-b" style="border-color:#2a2a2a;">
        <a href="{{ route('register') }}?type=musician"
           class="tab-link {{ $type === 'musician' ? 'active' : '' }}">
            Músico
        </a>
        <a href="{{ route('register') }}?type=establishment"
           class="tab-link {{ $type === 'establishment' ? 'active' : '' }}">
            Estabelecimento
        </a>
    </div>

    @if($type === 'musician')
    {{-- Musician Registration --}}
    <div class="flex flex-col md:flex-row gap-10">
        <div class="md:w-64 flex-shrink-0">
            <h1 class="text-2xl font-bold" style="color:#F59E0B;">Informações pessoais</h1>
            <p class="text-sm mt-2" style="color:#9CA3AF;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros.</p>
        </div>

        <div class="flex-1">
            {{-- Avatar placeholder --}}
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background:#2a2a2a;border:2px solid #333;">
                    <svg class="w-8 h-8" style="color:#555;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                </div>
                <button type="button" class="btn-outline-gold text-sm" style="padding:0.4rem 1rem;" onclick="document.getElementById('avatar_musician').click()">
                    Upload photo
                </button>
            </div>

            <form method="POST" action="/cadastro" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="musician">
                <input type="file" id="avatar_musician" name="avatar" class="hidden" accept="image/*">

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="label-gold">Nome</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                            class="input-field" required>
                        @error('first_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label-gold">Sobrenome</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                            class="input-field" required>
                        @error('last_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="label-gold">Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" style="color:#F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com"
                            class="input-field pl-9" required>
                    </div>
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="label-gold">Estado</label>
                    <select name="state" class="input-field">
                        <option value="">Selecione ...</option>
                        @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                            <option value="{{ $uf }}" {{ old('state') === $uf ? 'selected' : '' }}>{{ $uf }}</option>
                        @endforeach
                    </select>
                    @error('state')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="label-gold">Cidade</label>
                        <input type="text" name="city" value="{{ old('city') }}" class="input-field">
                        @error('city')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label-gold">CEP</label>
                        <input type="text" name="cep" value="{{ old('cep') }}" class="input-field" placeholder="00000-000">
                        @error('cep')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="label-gold">Endereço</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="input-field">
                    @error('address')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="label-gold">Senha</label>
                    <input type="password" name="password" class="input-field" required>
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="label-gold">Confirmar Senha</label>
                    <input type="password" name="password_confirmation" class="input-field" required>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('home') }}" class="btn-outline">Cancelar</a>
                    <button type="submit" class="btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    @else
    {{-- Establishment Registration --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold" style="color:#F59E0B;">Informações do estabelecimento</h1>
        <p class="text-sm mt-2" style="color:#9CA3AF;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros.</p>
    </div>

    <form method="POST" action="/cadastro" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="establishment">

        <div class="form-section">
            <div class="form-section-label">Nome do estabelecimento</div>
            <div>
                <input type="text" name="establishment_name" value="{{ old('establishment_name') }}" class="input-field" required>
                @error('establishment_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-label">CNPJ</div>
            <div>
                <input type="text" name="cnpj" value="{{ old('cnpj') }}" class="input-field" placeholder="00.000.000/0000-00">
                @error('cnpj')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-label">Website</div>
            <div class="flex">
                <span class="input-field" style="width:auto;border-right:none;border-radius:0.25rem 0 0 0.25rem;color:#9CA3AF;white-space:nowrap;flex-shrink:0;">http://</span>
                <input type="text" name="website" value="{{ old('website') }}" placeholder="www.exemplo.com.br"
                    class="input-field" style="border-radius:0 0.25rem 0.25rem 0;">
            </div>
            @error('website')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-section">
            <div class="form-section-label">Email</div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2">
                    <svg class="w-4 h-4" style="color:#F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com"
                    class="input-field pl-9" required>
            </div>
            @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-section">
            <div class="form-section-label">Password</div>
            <div class="space-y-3">
                <div class="relative">
                    <input type="password" name="password" placeholder="Senha" class="input-field pr-10" required>
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 toggle-pwd" style="color:#F59E0B;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <div class="relative">
                    <input type="password" name="password_confirmation" placeholder="Confirmar senha" class="input-field pr-10" required>
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2" style="color:#F59E0B;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('home') }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-primary">Salvar</button>
        </div>
    </form>
    @endif

</div>
@endsection
