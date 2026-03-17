<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GigMap') }} – @yield('title', 'Conectando Músicos e Estabelecimentos')</title>
    <meta name="description" content="@yield('meta_description', 'GigMap conecta músicos e estabelecimentos, facilitando a descoberta de artistas locais e a contratação para apresentações ao vivo.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>

{{-- Navbar (authenticated) --}}
<nav class="navbar">
    <div class="max-w-6xl mx-auto px-6 flex items-center h-14 gap-8">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex-shrink-0">
            <span class="text-2xl font-black tracking-tight" style="font-family:'IM Fell English',serif;color:#F5F5DC;">
                G<span style="color:#F59E0B;">i</span>G<span style="font-size:0.85em;"> M</span>a<span style="font-size:0.85em;">p</span>
            </span>
        </a>

        {{-- Nav links --}}
        <div class="hidden md:flex items-center gap-7 flex-1">
            <a href="{{ route('announcements.index') }}" class="btn-ghost text-sm">Anúncios</a>
            <a href="{{ route('home') }}#quem-somos" class="btn-ghost text-sm">Quem Somos</a>
            <a href="{{ route('home') }}#sobre" class="btn-ghost text-sm">Sobre o Projeto</a>
        </div>

        {{-- Search + user menu --}}
        <div class="flex items-center gap-3 ml-auto">
            <form action="{{ route('announcements.index') }}" method="GET" class="hidden md:flex items-center">
                <div class="flex items-center border border-amber-500 rounded px-3 py-1.5 gap-2" style="background:#1a1a1a;">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search"
                        class="bg-transparent text-sm text-gray-200 outline-none w-40 placeholder-gray-500">
                </div>
            </form>

            {{-- Bell --}}
            <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/5 transition-colors">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </button>

            {{-- Avatar dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="w-9 h-9 rounded-full overflow-hidden border-2 border-amber-500 flex items-center justify-center"
                    style="background:#2a2a2a;">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->getAvatarUrl() }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    @endif
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-44 rounded-md shadow-xl py-1 z-50"
                    style="background:#1c1c1c; border:1px solid #333;" x-cloak>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-amber-400 hover:bg-white/5 transition-colors">
                        Meu Perfil
                    </a>
                    <a href="{{ route('announcements.create') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-amber-400 hover:bg-white/5 transition-colors">
                        Criar Anúncio
                    </a>
                    <hr style="border-color:#333;" class="my-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:text-amber-400 hover:bg-white/5 transition-colors">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
<div class="max-w-6xl mx-auto px-6 mt-4">
    <div class="alert-success">{{ session('success') }}</div>
</div>
@endif
@if($errors->any())
<div class="max-w-6xl mx-auto px-6 mt-4">
    <div class="alert-error">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

{{-- Page content --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
@include('partials.footer')

@stack('scripts')
<script>
// Simple alpine-like dropdown toggle for vanilla JS
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[x-data]').forEach(el => {
        const btn = el.querySelector('[\\@click]');
        const menu = el.querySelector('[x-show]');
        if (!btn || !menu) return;
        menu.style.display = 'none';
        btn.addEventListener('click', () => {
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        });
        document.addEventListener('click', (e) => {
            if (!el.contains(e.target)) menu.style.display = 'none';
        });
    });
});
</script>
</body>
</html>
