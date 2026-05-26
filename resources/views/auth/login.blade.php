@extends('layouts.guest')

@section('title', 'Fazer Login')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 py-12 sm:py-16 animate-fade-in-up">
    <h1 class="text-2xl sm:text-3xl font-bold mb-2" style="color:#F59E0B;">Fazer Login</h1>
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
                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 toggle-pwd" style="color:#F59E0B;">
                    <svg class="eye-open w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg class="eye-closed w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="accent-amber-400">
                <label for="remember" class="text-sm" style="color:#9CA3AF;">Lembrar de mim</label>
            </div>
            <button type="button" id="openResetModal" class="text-sm font-semibold hover:text-amber-300 transition-colors" style="color:#F59E0B;">
                Esqueci minha senha
            </button>
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

{{-- ══════════ Password Reset Modal ══════════ --}}
<div id="resetModal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);">
    <div class="w-full max-w-md mx-4 rounded-xl p-6 animate-fade-in-up" style="background:#141414;border:1px solid #2a2a2a;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold" style="color:#F59E0B;">Redefinir Senha</h2>
                <p class="text-xs mt-1" style="color:#9CA3AF;">Informe seu e-mail e defina uma nova senha.</p>
            </div>
            <button type="button" id="closeResetModal" class="rounded-full p-1.5 transition-colors" style="color:#9CA3AF;background:#1a1a1a;" onmouseover="this.style.color='#F59E0B'" onmouseout="this.style.color='#9CA3AF'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Validation errors --}}
        @if($errors->has('reset_email'))
        <div class="mb-4 p-3 rounded-lg text-sm" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#fca5a5;">
            {{ $errors->first('reset_email') }}
        </div>
        @endif
        @if($errors->has('password') && session('open_reset_modal'))
        <div class="mb-4 p-3 rounded-lg text-sm" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#fca5a5;">
            {{ $errors->first('password') }}
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('password.reset') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label class="label-gold">E-mail cadastrado</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2">
                        <svg class="w-4 h-4" style="color:#F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input type="email" name="email" value="{{ old('reset_email') }}" placeholder="email@example.com"
                        class="input-field pl-9" required>
                </div>
            </div>

            {{-- New Password --}}
            <div>
                <label class="label-gold">Nova senha</label>
                <div class="relative">
                    <input type="password" name="password" placeholder="Mínimo 8 caracteres" class="input-field pr-10" required minlength="8">
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 toggle-pwd" style="color:#F59E0B;">
                        <svg class="eye-open w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg class="eye-closed w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="label-gold">Confirmar nova senha</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" placeholder="Repita a nova senha" class="input-field pr-10" required minlength="8">
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 toggle-pwd" style="color:#F59E0B;">
                        <svg class="eye-open w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg class="eye-closed w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-primary w-full justify-center py-2.5 text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Redefinir Senha
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ── Toggle password visibility ──────────────────────
document.querySelectorAll('.toggle-pwd').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = btn.closest('.relative').querySelector('input');
        const eyeOpen = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');
        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen?.classList.add('hidden');
            eyeClosed?.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen?.classList.remove('hidden');
            eyeClosed?.classList.add('hidden');
        }
    });
});

// ── Reset Password Modal ────────────────────────────
const modal = document.getElementById('resetModal');
const openBtn = document.getElementById('openResetModal');
const closeBtn = document.getElementById('closeResetModal');

function openModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

openBtn?.addEventListener('click', openModal);
closeBtn?.addEventListener('click', closeModal);

// Close on backdrop click
modal?.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
});

// Close on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
});

// Auto-open modal if there were validation errors on the reset form
@if(session('open_reset_modal'))
    openModal();
@endif
</script>
@endpush
