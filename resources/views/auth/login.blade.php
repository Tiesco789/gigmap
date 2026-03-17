@extends('layouts.guest')

@section('title', 'Fazer Login')

@section('content')
<div class="max-w-md mx-auto px-6 py-16 animate-fade-in-up">
    <h1 class="text-3xl font-bold mb-2" style="color:#F59E0B;">Fazer Login</h1>
    <p class="text-sm mb-8" style="color:#9CA3AF;">Entre na sua conta GigMap para continuar.</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="label-gold">Email</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2">
                    <svg class="w-4 h-4" style="color:#F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com"
                    class="input-field pl-9" required autofocus>
            </div>
            @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="label-gold">Senha</label>
            <div class="relative">
                <input type="password" name="password" placeholder="Sua senha" class="input-field pr-10" required>
                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2" style="color:#F59E0B;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="accent-amber-400">
            <label for="remember" class="text-sm" style="color:#9CA3AF;">Lembrar de mim</label>
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-2.5 text-base">
            Entrar
        </button>
    </form>

    <p class="mt-6 text-sm text-center" style="color:#9CA3AF;">
        Não tem uma conta?
        <a href="{{ route('register') }}" class="font-semibold hover:text-amber-300 transition-colors" style="color:#F59E0B;">Cadastre-se</a>
    </p>
</div>
@endsection
