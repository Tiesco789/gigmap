<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GigMap – Conectando Músicos e Estabelecimentos</title>
    <meta name="description" content="GigMap conecta músicos e estabelecimentos, facilitando a descoberta de artistas locais e contratação para apresentações ao vivo.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:#111111;color:#F5F5DC;font-family:'Inter',sans-serif;">

{{-- ═══ NAVBAR ═══ --}}
<nav class="navbar">
    <div class="max-w-6xl mx-auto px-6 flex items-center h-14 gap-8">
        <a href="{{ route('home') }}" class="flex-shrink-0">
            <span style="font-family:'IM Fell English',serif;font-size:1.5rem;font-weight:900;color:#F5F5DC;letter-spacing:0.02em;">
                G<span style="color:#F59E0B;">i</span>G<span style="font-size:0.8em;"> M</span>a<span style="font-size:0.8em;">p</span>
            </span>
        </a>
        <div class="hidden md:flex items-center gap-7 flex-1">
            <a href="{{ route('announcements.index') }}" class="btn-ghost text-sm">Anúncios</a>
            <a href="#quem-somos" class="btn-ghost text-sm">Quem Somos</a>
            <a href="#sobre" class="btn-ghost text-sm">Sobre o Projeto</a>
        </div>
        <div class="flex items-center gap-3 ml-auto">
            @auth
            <a href="{{ route('announcements.index') }}" class="btn-primary text-sm" style="padding:0.4rem 1rem;">Ver Anúncios</a>
            @else
            <a href="{{ route('login') }}" class="btn-outline-gold text-sm" style="padding:0.4rem 1rem;">Fazer Login</a>
            <a href="{{ route('register') }}" class="btn-primary text-sm" style="padding:0.4rem 1rem;">Cadastre-se</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ═══ HERO ═══ --}}
<section style="background:#111;" class="py-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-5" style="color:#F59E0B;">
                    Conectando músicos e estabelecimentos em um só lugar
                </h1>
                <p class="text-base mb-8" style="color:#9CA3AF;">
                    Encontre oportunidades, agende apresentações e fortaleça sua presença na cena musical.
                </p>
                <form action="{{ route('register') }}" class="flex flex-col sm:flex-row gap-3 max-w-md">
                    <div class="relative flex-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" style="color:#9CA3AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input type="email" placeholder="Digite seu e-mail" class="input-field pl-9">
                    </div>
                    <button type="submit" class="btn-primary flex-shrink-0">Começar agora</button>
                </form>
                <p class="text-xs mt-3" style="color:#555;">
                    Ao criar uma conta, você confirma que aceita nossos
                    <a href="#" style="color:#F59E0B;">Termos e Condições</a>.
                </p>
            </div>
            <div class="animate-fade-in-up delay-200">
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-lg overflow-hidden" style="aspect-ratio:4/3;background:#1e1e1e;">
                        <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,#1a1a1a,#2a2a2a);">
                            <svg class="w-16 h-16" style="color:#333;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="rounded-lg overflow-hidden" style="aspect-ratio:4/3;background:linear-gradient(135deg,#2d1b4e,#1a1a2e);">
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16" style="color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ COMO FUNCIONA – Músicos ═══ --}}
<section id="quem-somos" class="py-16" style="background:#111;">
    <div class="max-w-6xl mx-auto px-6">
        <p class="text-xs font-semibold mb-2" style="color:#9CA3AF;">Para músicos</p>
        <h2 class="text-3xl font-bold mb-8">Como Funciona</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Card 1 --}}
            <div class="rounded-lg overflow-hidden relative" style="background:#1a1a1a;min-height:220px;">
                <div class="absolute inset-0" style="background:linear-gradient(135deg,#1a1a1a 40%,#2d1a00);"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <h3 class="text-lg font-bold mb-2" style="color:#F59E0B;">Mostre seu talento</h3>
                    <p class="text-sm" style="color:#9CA3AF;">Descubra bares, casas de show e eventos que procuram artistas, receba avaliações e destaque-se no seu trabalho.</p>
                </div>
            </div>
            {{-- Card 2 --}}
            <div class="rounded-lg overflow-hidden relative" style="background:#1a1a1a;min-height:220px;">
                <div class="absolute inset-0" style="background:linear-gradient(135deg,#1a002d,#2d1a1a);"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <h3 class="text-lg font-bold mb-2" style="color:#F59E0B;">Visibilidade profissional</h3>
                    <p class="text-sm" style="color:#9CA3AF;">Mais chances de tocar, comunicação sem intermediários e avaliações que valorizam o seu trabalho.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ COMO FUNCIONA – Estabelecimentos ═══ --}}
<section class="py-16" style="background:#0e0e0e;">
    <div class="max-w-6xl mx-auto px-6">
        <p class="text-xs font-semibold mb-2" style="color:#9CA3AF;">Para estabelecimentos</p>
        <h2 class="text-3xl font-bold mb-8">Como Funciona</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="rounded-lg overflow-hidden relative" style="background:#1a1a1a;min-height:220px;">
                <div class="absolute inset-0" style="background:linear-gradient(135deg,#1a1500,#2a2a1a);"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <h3 class="text-lg font-bold mb-2" style="color:#F59E0B;">Encontre músicos com o estilo ideal para o seu negócio</h3>
                    <p class="text-sm" style="color:#9CA3AF;">Publique oportunidades ou contrate diretamente pelo nosso sistema, organize sua agenda e atraia mais público.</p>
                </div>
            </div>
            <div class="rounded-lg overflow-hidden relative" style="background:#1a1a1a;min-height:220px;">
                <div class="absolute inset-0" style="background:linear-gradient(135deg,#001a1a,#0d2a2a);"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <h3 class="text-lg font-bold mb-2" style="color:#F59E0B;">Acesso a músicos qualificados e avaliados.</h3>
                    <p class="text-sm" style="color:#9CA3AF;">Processo de contratação simplificado para atrair mais público com música ao vivo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ TRANSFORME TALENTO ═══ --}}
<section class="py-20 text-center" style="background:#111;">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-4xl md:text-5xl font-extrabold mb-4" style="color:#F59E0B;">
            Transforme talento em oportunidade.
        </h2>
        <p class="text-base mb-12" style="color:#9CA3AF;">
            Com o GigMap, músicos e estabelecimentos se conectam de forma rápida, segura e profissional.
        </p>

        {{-- Photo mosaic --}}
        <div class="grid grid-cols-4 grid-rows-2 gap-3 h-72">
            @for($i = 1; $i <= 8; $i++)
            <div class="rounded-lg overflow-hidden"
                style="background:linear-gradient({{ $i * 45 }}deg,#{{ ['1a0a2e','0a1a2e','2e1a0a','0a2e1a','2e0a1a','1a2e0a','2e2e0a','0a2e2e'][$i-1] }},#1a1a1a);">
            </div>
            @endfor
        </div>
    </div>
</section>

{{-- ═══ SOBRE + DIFICULDADES ═══ --}}
<section id="sobre" class="py-20" style="background:#0e0e0e;">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            {{-- Dificuldades --}}
            <div class="p-6 rounded-lg" style="background:#F59E0B;">
                <h3 class="text-lg font-bold mb-4" style="color:#111;">As dificuldades</h3>
                <p class="text-sm leading-relaxed" style="color:#222;">
                    Muitos músicos têm dificuldade para encontrar espaços onde podem se apresentar e crescer. Ao mesmo tempo, estabelecimentos nem sempre sabem como atrair e contratar artistas de show, buscam constantemente maneiras de atrair público e conectar o GigMap surge como solução unificadora para ambos os lados.
                </p>
            </div>

            {{-- Sobre o GigMap --}}
            <div>
                <p class="text-xs font-semibold mb-2" style="color:#9CA3AF;">Motivação do projeto</p>
                <h2 class="text-3xl font-bold mb-4" style="color:#F59E0B;">Sobre o GigMap</h2>
                <p class="text-sm leading-relaxed" style="color:#9CA3AF;">
                    O GigMap nasceu para aproximar músicos independentes e estabelecimentos que buscam oferecer experiências musicais únicas. Acreditamos que a música conecta pessoas, cria ambientes e fortalece a economia criativa. Nossa missão é criar uma plataforma simples, eficiente e acessível para artistas e oportunidades.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ═══ PROCESSO (TIMELINE) ═══ --}}
<section class="py-20" style="background:#111;">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-4">Processo</h2>
        <p class="text-center text-sm mb-16" style="color:#9CA3AF;">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.
        </p>

        <div class="relative">
            {{-- Vertical line --}}
            <div class="absolute left-1/2 top-0 bottom-0 w-px" style="background:#F59E0B;transform:translateX(-50%);"></div>

            @php
            $steps = [
                ['title' => 'Cadastro', 'side' => 'right'],
                ['title' => 'Busca', 'side' => 'left'],
                ['title' => 'Proposta', 'side' => 'right'],
                ['title' => 'Contrato', 'side' => 'left'],
            ];
            @endphp

            @foreach($steps as $i => $step)
            <div class="flex items-start mb-16 relative
                {{ $step['side'] === 'right' ? 'flex-row-reverse' : '' }}">

                {{-- Dot --}}
                <div class="absolute left-1/2 top-2 w-3 h-3 rounded-full border-2 z-10"
                    style="background:#F59E0B;border-color:#F59E0B;transform:translateX(-50%);"></div>

                {{-- Content --}}
                <div class="w-5/12 {{ $step['side'] === 'right' ? 'pl-10' : 'pr-10 text-right' }}">
                    <h3 class="text-xl font-bold mb-3" style="color:#F59E0B;">{{ $step['title'] }}</h3>
                    <p class="text-sm leading-relaxed" style="color:#9CA3AF;">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae erat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                </div>
                <div class="w-5/12"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ FOOTER ═══ --}}
@include('partials.footer')

</body>
</html>
