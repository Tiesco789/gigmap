<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GigMap') }} – @yield('title', 'Conectando Músicos e Estabelecimentos')</title>
    <meta name="description" content="@yield('meta_description', 'GigMap conecta músicos e estabelecimentos, facilitando a descoberta de artistas locais e a contratação para apresentações ao vivo.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>

{{-- Navbar (unauthenticated) --}}
<nav class="navbar" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center h-14 gap-8">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/logo-gigmap.svg') }}" width="120"  />
        </a>

        {{-- Nav links (desktop only) --}}
        <div class="hidden desktop:flex items-center gap-7 flex-1">
            <a href="{{ route('announcements.index') }}" class="btn-ghost text-sm">Anúncios</a>
            <a href="{{ route('home') }}#quem-somos" class="btn-ghost text-sm">Quem Somos</a>
            <a href="{{ route('home') }}#sobre" class="btn-ghost text-sm">Sobre o Projeto</a>
        </div>

        {{-- Auth buttons + hamburger --}}
        <div class="flex items-center gap-3 ml-auto">
            <a href="{{ route('login') }}" class="btn-outline-gold text-sm hidden sm:inline-flex" style="padding:0.4rem 1rem;">Fazer Login</a>
            <a href="{{ route('register') }}" class="btn-primary text-sm hidden sm:inline-flex" style="padding:0.4rem 1rem;">Cadastre-se</a>

            {{-- Hamburger button (mobile/tablet) --}}
            <button class="hamburger-btn desktop:hidden" @click="mobileMenuOpen = !mobileMenuOpen" :aria-expanded="mobileMenuOpen.toString()" aria-label="Abrir menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    {{-- Mobile Menu Overlay --}}
    <div class="mobile-menu-overlay desktop:hidden" :class="{ 'active': mobileMenuOpen }" @click="mobileMenuOpen = false"></div>

    {{-- Mobile Menu Panel --}}
    <div class="mobile-menu desktop:hidden" :class="{ 'active': mobileMenuOpen }">
        <div class="mobile-menu-header">
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('assets/logo-gigmap.svg') }}" width="100" />
            </a>
            <button class="mobile-menu-close" @click="mobileMenuOpen = false" aria-label="Fechar menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="mobile-menu-body">
            {{-- Nav links --}}
            <a href="{{ route('announcements.index') }}" class="mobile-menu-link" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Anúncios
            </a>
            <a href="{{ route('home') }}#quem-somos" class="mobile-menu-link" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Quem Somos
            </a>
            <a href="{{ route('home') }}#sobre" class="mobile-menu-link" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Sobre o Projeto
            </a>

            <hr class="mobile-menu-divider">

            {{-- Auth buttons --}}
            <a href="{{ route('login') }}" class="mobile-menu-link" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Fazer Login
            </a>
            <a href="{{ route('register') }}" class="mobile-menu-link" style="color:#F59E0B;" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Cadastre-se
            </a>
        </div>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
<div class="max-w-6xl mx-auto px-6 mt-4">
    <div class="alert-success">{{ session('success') }}</div>
</div>
@endif

{{-- Page content --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
@include('partials.footer')

@stack('scripts')
</body>
</html>
