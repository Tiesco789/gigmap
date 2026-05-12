<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GigMap – Conectando Músicos e Estabelecimentos</title>
    <meta name="description" content="GigMap conecta músicos e estabelecimentos, facilitando a descoberta de artistas locais e contratação para apresentações ao vivo.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:#111111;color:#F5F5DC;font-family:'Bricolage Grotesque','Merriweather',sans-serif;">

{{-- ═══ NAVBAR ═══ --}}
<nav class="navbar">
    <div class="max-w-6xl mx-auto px-6 flex items-center h-14 gap-8">
        <a href="{{ route('home') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/logo-gigmap.svg') }}" width="120"  />
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
                @if(session('success'))
                <div class="rounded-lg px-4 py-3 mb-4 text-sm font-medium" style="background:rgba(16,185,129,0.15);color:#10B981;border:1px solid rgba(16,185,129,0.3);">
                    ✓ {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="rounded-lg px-4 py-3 mb-4 text-sm font-medium" style="background:rgba(239,68,68,0.15);color:#EF4444;border:1px solid rgba(239,68,68,0.3);">
                    ✗ {{ session('error') }}
                </div>
                @endif
                @if($errors->has('email'))
                <div class="rounded-lg px-4 py-3 mb-4 text-sm font-medium" style="background:rgba(239,68,68,0.15);color:#EF4444;border:1px solid rgba(239,68,68,0.3);">
                    ✗ {{ $errors->first('email') }}
                </div>
                @endif
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-md">
                    @csrf
                    <div class="relative flex-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" style="color:#9CA3AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input type="email" name="email" placeholder="Digite seu e-mail" class="input-field pl-9" required>
                    </div>
                    <button type="submit" class="btn-primary flex-shrink-0">Assinar newsletter</button>
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
            <div class="img-card rounded-lg overflow-hidden relative" style="background:#1a1a1a;min-height:220px;">
                <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=800&q=80&auto=format&fit=crop&client_id=xH4ATu3SjujDCUpYxa2U3oz15S8y9It1kGknUDilYco"
                     alt="Músico tocando guitarra"
                     class="img-card__photo absolute inset-0 w-full h-full"
                     style="object-fit:cover;" />
                <div class="img-card__overlay absolute inset-0"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6" style="z-index:1;">
                    <h3 class="text-lg font-bold mb-2" style="color:#F59E0B;">Mostre seu talento</h3>
                    <p class="text-sm" style="color:#ccc;">Descubra bares, casas de show e eventos que procuram artistas, receba avaliações e destaque-se no seu trabalho.</p>
                </div>
            </div>
            {{-- Card 2 --}}
            <div class="img-card rounded-lg overflow-hidden relative" style="background:#1a1a1a;min-height:220px;">
                <img src="https://images.unsplash.com/photo-1501612780327-45045538702b?w=800&q=80&auto=format&fit=crop&client_id=xH4ATu3SjujDCUpYxa2U3oz15S8y9It1kGknUDilYco"
                     alt="Palco com iluminação de show ao vivo"
                     class="img-card__photo absolute inset-0 w-full h-full"
                     style="object-fit:cover;" />
                <div class="img-card__overlay absolute inset-0"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6" style="z-index:1;">
                    <h3 class="text-lg font-bold mb-2" style="color:#F59E0B;">Visibilidade profissional</h3>
                    <p class="text-sm" style="color:#ccc;">Mais chances de tocar, comunicação sem intermediários e avaliações que valorizam o seu trabalho.</p>
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
            <div class="img-card rounded-lg overflow-hidden relative" style="background:#1a1a1a;min-height:220px;">
                <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=800&q=80&auto=format&fit=crop&client_id=xH4ATu3SjujDCUpYxa2U3oz15S8y9It1kGknUDilYco"
                     alt="Bar com ambiente acolhedor"
                     class="img-card__photo absolute inset-0 w-full h-full"
                     style="object-fit:cover;" />
                <div class="img-card__overlay absolute inset-0"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6" style="z-index:1;">
                    <h3 class="text-lg font-bold mb-2" style="color:#F59E0B;">Encontre músicos com o estilo ideal para o seu negócio</h3>
                    <p class="text-sm" style="color:#ccc;">Publique oportunidades ou contrate diretamente pelo nosso sistema, organize sua agenda e atraia mais público.</p>
                </div>
            </div>
            <div class="img-card rounded-lg overflow-hidden relative" style="background:#1a1a1a;min-height:220px;">
                <img src="https://images.unsplash.com/photo-1524368535928-5b5e00ddc76b?w=800&q=80&auto=format&fit=crop&client_id=xH4ATu3SjujDCUpYxa2U3oz15S8y9It1kGknUDilYco"
                     alt="Público curtindo show ao vivo"
                     class="img-card__photo absolute inset-0 w-full h-full"
                     style="object-fit:cover;" />
                <div class="img-card__overlay absolute inset-0"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6" style="z-index:1;">
                    <h3 class="text-lg font-bold mb-2" style="color:#F59E0B;">Acesso a músicos qualificados e avaliados.</h3>
                    <p class="text-sm" style="color:#ccc;">Processo de contratação simplificado para atrair mais público com música ao vivo.</p>
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
        @php
        $mosaicPhotos = [
            ['id' => 'photo-1493225457124-a3eb161ffa5f', 'alt' => 'Guitarrista no palco',        'span' => 'col-span-2'],
            ['id' => 'photo-1598488035139-bdbb2231ce04', 'alt' => 'Microfone em destaque',        'span' => ''],
            ['id' => 'photo-1459749411175-04bf5292ceea', 'alt' => 'Show de luzes',                'span' => 'row-span-3'],
            ['id' => 'photo-1470225620780-dba8ba36b745', 'alt' => 'DJ mixando',                   'span' => ''],
            ['id' => 'photo-1516450360452-9312f5e86fc7', 'alt' => 'Público em festival',          'span' => 'col-span-2'],
            ['id' => 'photo-1506157786151-b8491531f063', 'alt' => 'Concerto ao vivo',             'span' => ''],
            ['id' => 'photo-1524368535928-5b5e00ddc76b', 'alt' => 'Multidão em show',             'span' => ''],
            ['id' => 'photo-1415201364774-f6f0bb35f28f', 'alt' => 'Músico com violão',            'span' => ''],
        ];
        @endphp
        <div class="grid grid-cols-4 auto-rows-[140px] gap-3">
            @foreach($mosaicPhotos as $photo)
            <div class="rounded-lg overflow-hidden relative group {{ $photo['span'] }}" style="background:#1a1a1a;">
                <img src="https://images.unsplash.com/{{ $photo['id'] }}?w=600&q=75&auto=format&fit=crop&client_id=xH4ATu3SjujDCUpYxa2U3oz15S8y9It1kGknUDilYco"
                     alt="{{ $photo['alt'] }}"
                     class="absolute inset-0 w-full h-full"
                     style="object-fit:cover;transition:transform .5s ease;" loading="lazy"
                     onmouseenter="this.style.transform='scale(1.08)'"
                     onmouseleave="this.style.transform='scale(1)'" />
                <div class="absolute inset-0" style="background:rgba(0,0,0,0.15);pointer-events:none;"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SOBRE + DIFICULDADES ═══ --}}
<section id="sobre" class="py-20" style="background:#0e0e0e;">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

            {{-- Card shuffle stack --}}
            <div style="position:relative;padding-bottom:3.5rem;">
                <div class="shuffle-deck" id="shuffleDeck" style="position:relative;height:240px;">
                    <div class="shuffle-card" data-shuffle-index="0">
                        <div class="shuffle-card__icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="shuffle-card__title">As dificuldades</h3>
                        <p class="shuffle-card__text">Muitos músicos têm dificuldade para encontrar espaços onde podem se apresentar e crescer profissionalmente.</p>
                    </div>

                    <div class="shuffle-card" data-shuffle-index="1">
                        <div class="shuffle-card__icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="shuffle-card__title">Estabelecimentos</h3>
                        <p class="shuffle-card__text">Bares e casas de show nem sempre sabem como encontrar e contratar artistas qualificados para suas noites.</p>
                    </div>

                    <div class="shuffle-card" data-shuffle-index="2">
                        <div class="shuffle-card__icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="shuffle-card__title">A solução</h3>
                        <p class="shuffle-card__text">O GigMap conecta ambos os lados: músicos encontram palcos e estabelecimentos encontram talentos rapidamente.</p>
                    </div>

                    <div class="shuffle-card" data-shuffle-index="3">
                        <div class="shuffle-card__icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <h3 class="shuffle-card__title">Resultado</h3>
                        <p class="shuffle-card__text">Mais shows, mais público, mais receita. Uma plataforma que fortalece a economia criativa e a cena musical local.</p>
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="shuffle-nav" style="position:absolute;bottom:0;left:0;right:0;z-index:10;">
                    <button class="shuffle-btn" id="shufflePrev" aria-label="Anterior">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <div class="shuffle-dots" id="shuffleDots">
                        <span class="shuffle-dot active"></span>
                        <span class="shuffle-dot"></span>
                        <span class="shuffle-dot"></span>
                        <span class="shuffle-dot"></span>
                    </div>
                    <button class="shuffle-btn" id="shuffleNext" aria-label="Próximo">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const deck = document.getElementById('shuffleDeck');
                const cards = Array.from(deck.querySelectorAll('.shuffle-card'));
                const dots = Array.from(document.getElementById('shuffleDots').children);
                const total = cards.length;
                let current = 0;
                let isAnimating = false;

                // Stack positions: index 0 = front, 1 = behind, etc.
                const positions = [
                    { y: 0,  scale: 1,    opacity: 1,    z: 4 },
                    { y: 12, scale: 0.97, opacity: 0.85, z: 3 },
                    { y: 24, scale: 0.94, opacity: 0.65, z: 2 },
                    { y: 36, scale: 0.91, opacity: 0.45, z: 1 },
                ];

                function applyPositions() {
                    cards.forEach((card, i) => {
                        // How far behind the front is this card?
                        const offset = ((i - current) % total + total) % total;
                        const pos = positions[offset];
                        card.style.transform = `translateY(${pos.y}px) scale(${pos.scale})`;
                        card.style.opacity = pos.opacity;
                        card.style.zIndex = pos.z;
                    });
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === current);
                    });
                }

                function goNext() {
                    if (isAnimating) return;
                    isAnimating = true;

                    // Lift the front card before shuffling
                    const frontCard = cards[current];
                    frontCard.style.transform = 'translateY(-30px) scale(1.02) rotateX(-3deg)';
                    frontCard.style.opacity = '1';

                    setTimeout(() => {
                        current = (current + 1) % total;
                        applyPositions();
                        setTimeout(() => { isAnimating = false; }, 500);
                    }, 280);
                }

                function goPrev() {
                    if (isAnimating) return;
                    isAnimating = true;

                    // The card about to come to front lifts from bottom
                    const prevIndex = (current - 1 + total) % total;
                    const prevCard = cards[prevIndex];
                    prevCard.style.transform = 'translateY(50px) scale(0.88)';
                    prevCard.style.opacity = '0.3';

                    setTimeout(() => {
                        current = prevIndex;
                        applyPositions();
                        setTimeout(() => { isAnimating = false; }, 500);
                    }, 280);
                }

                document.getElementById('shuffleNext').addEventListener('click', goNext);
                document.getElementById('shufflePrev').addEventListener('click', goPrev);

                // Initialize
                applyPositions();
            });
            </script>

            {{-- Sobre o GigMap --}}
            <div>
                <p class="text-xs font-semibold mb-2" style="color:#9CA3AF;">Motivação do projeto</p>
                <h2 class="text-3xl font-bold mb-4" style="color:#F59E0B;">Sobre o GigMap</h2>
                <p class="text-sm leading-relaxed mb-6" style="color:#9CA3AF;">
                    O GigMap nasceu para aproximar músicos independentes e estabelecimentos que buscam oferecer experiências musicais únicas. Acreditamos que a música conecta pessoas, cria ambientes e fortalece a economia criativa.
                </p>
                <p class="text-sm leading-relaxed" style="color:#9CA3AF;">
                    Nossa missão é criar uma plataforma simples, eficiente e acessível para artistas e oportunidades. Uma ponte entre quem faz música e quem quer oferecê-la ao público.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ═══ PROCESSO (TIMELINE) ═══ --}}
<section class="py-20" style="background:#111;" id="processo">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-4">Processo</h2>
        <p class="text-center text-sm mb-16" style="color:#9CA3AF;">
            Do cadastro ao palco em poucos passos. Veja como é simples conectar talento e oportunidade.
        </p>

        <div class="relative" id="timeline-container">
            {{-- Background track --}}
            <div class="absolute left-1/2 top-0 bottom-0 w-px" style="background:#2a2a2a;transform:translateX(-50%);"></div>
            {{-- Animated fill line --}}
            <div class="absolute left-1/2 top-0 w-px" id="timeline-progress"
                 style="background:#F59E0B;transform:translateX(-50%);height:0;transition:height 0.3s ease;"></div>

            @php
            $steps = [
                [
                    'title' => 'Cadastro',
                    'desc'  => 'Crie sua conta em segundos como músico ou estabelecimento. Preencha seu perfil com fotos, gêneros musicais e disponibilidade.',
                    'icon'  => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                    'side'  => 'right',
                ],
                [
                    'title' => 'Busca',
                    'desc'  => 'Navegue por anúncios de oportunidades ou busque artistas por gênero, localização e avaliação. Filtros inteligentes facilitam a descoberta.',
                    'icon'  => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                    'side'  => 'left',
                ],
                [
                    'title' => 'Proposta',
                    'desc'  => 'Envie ou receba propostas diretamente pela plataforma. Negocie cachê, data e detalhes sem intermediários.',
                    'icon'  => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                    'side'  => 'right',
                ],
                [
                    'title' => 'Contrato',
                    'desc'  => 'Confirme a apresentação, alinhe os últimos detalhes e suba ao palco. Após o show, ambos avaliam a experiência.',
                    'icon'  => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'side'  => 'left',
                ],
            ];
            @endphp

            @foreach($steps as $i => $step)
            <div class="timeline-step flex items-start mb-20 relative
                {{ $step['side'] === 'right' ? 'flex-row-reverse' : '' }}"
                 data-side="{{ $step['side'] }}"
                 style="opacity:0;transform:translateY(40px);transition:opacity 0.6s ease {{ $i * 0.15 }}s, transform 0.6s ease {{ $i * 0.15 }}s;">

                {{-- Center dot with number --}}
                <div class="absolute left-1/2 top-1 z-20 flex items-center justify-center"
                     style="transform:translateX(-50%);">
                    <div class="timeline-dot w-10 h-10 rounded-full flex items-center justify-center"
                         style="background:#1a1a1a;border:2px solid #2a2a2a;transition:border-color 0.4s ease, box-shadow 0.4s ease;">
                        <span class="text-xs font-bold" style="color:#F59E0B;">0{{ $i + 1 }}</span>
                    </div>
                </div>

                {{-- Content card --}}
                <div class="w-5/12 {{ $step['side'] === 'right' ? 'pl-12' : 'pr-12 text-right' }}">
                    <div class="timeline-card p-5 rounded-lg"
                         style="background:#1a1a1a;border:1px solid #2a2a2a;transition:border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;"
                         onmouseenter="this.style.borderColor='#F59E0B';this.style.boxShadow='0 8px 30px rgba(245,158,11,0.12)';this.style.transform='translateY(-3px)';"
                         onmouseleave="this.style.borderColor='#2a2a2a';this.style.boxShadow='none';this.style.transform='translateY(0)';">
                        <div class="{{ $step['side'] === 'right' ? '' : 'flex flex-col items-end' }}">
                            <div class="w-9 h-9 rounded-md flex items-center justify-center mb-3"
                                 style="background:rgba(245,158,11,0.1);">
                                <svg class="w-5 h-5" style="color:#F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold mb-2" style="color:#F59E0B;">{{ $step['title'] }}</h3>
                        <p class="text-sm leading-relaxed" style="color:#9CA3AF;">{{ $step['desc'] }}</p>
                    </div>
                </div>
                <div class="w-5/12"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Timeline scroll animation --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.timeline-step');
    const progress = document.getElementById('timeline-progress');
    const container = document.getElementById('timeline-container');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                const dot = entry.target.querySelector('.timeline-dot');
                if (dot) {
                    dot.style.borderColor = '#F59E0B';
                    dot.style.boxShadow = '0 0 20px rgba(245,158,11,0.35)';
                }
            }
        });
    }, { threshold: 0.3 });

    steps.forEach(step => observer.observe(step));

    // Progress line fill on scroll
    function updateProgress() {
        const rect = container.getBoundingClientRect();
        const containerTop = rect.top + window.scrollY;
        const containerHeight = rect.height;
        const scrolled = window.scrollY + window.innerHeight * 0.6 - containerTop;
        const pct = Math.min(Math.max(scrolled / containerHeight, 0), 1);
        progress.style.height = (pct * 100) + '%';
    }

    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();
});
</script>

{{-- ═══ FOOTER ═══ --}}
@include('partials.footer')

</body>
</html>
