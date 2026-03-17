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

{{-- Navbar (unauthenticated) --}}
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

        {{-- Auth buttons --}}
        <div class="flex items-center gap-3 ml-auto">
            <a href="{{ route('login') }}" class="btn-outline-gold text-sm" style="padding:0.4rem 1rem;">Fazer Login</a>
            <a href="{{ route('register') }}" class="btn-primary text-sm" style="padding:0.4rem 1rem;">Cadastre-se</a>
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
