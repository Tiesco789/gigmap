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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
</head>
<body style="background:#111111;color:#F5F5DC;font-family:'Bricolage Grotesque','Merriweather',sans-serif;">

{{-- ═══ NAVBAR ═══ --}}
<nav class="navbar" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center h-14 gap-8">
        <a href="{{ route('home') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/logo-gigmap.svg') }}" width="120"  />
        </a>

        <div class="hidden desktop:flex items-center gap-7 flex-1">
            <a href="{{ route('announcements.index') }}" class="btn-ghost text-sm">Anúncios</a>
            <a href="#quem-somos" class="btn-ghost text-sm">Quem Somos</a>
            <a href="#sobre" class="btn-ghost text-sm">Sobre o Projeto</a>
        </div>
        <div class="flex items-center gap-3 ml-auto">
            @auth
            <a href="{{ route('announcements.index') }}" class="btn-primary text-sm hidden sm:inline-flex" style="padding:0.4rem 1rem;">Ver Anúncios</a>
            @else
            <a href="{{ route('login') }}" class="btn-outline-gold text-sm hidden sm:inline-flex" style="padding:0.4rem 1rem;">Fazer Login</a>
            <a href="{{ route('register') }}" class="btn-primary text-sm hidden sm:inline-flex" style="padding:0.4rem 1rem;">Cadastre-se</a>
            @endauth

            {{-- Hamburger button --}}
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
            <a href="{{ route('announcements.index') }}" class="mobile-menu-link" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Anúncios
            </a>
            <a href="#quem-somos" class="mobile-menu-link" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Quem Somos
            </a>
            <a href="#sobre" class="mobile-menu-link" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Sobre o Projeto
            </a>
            <hr class="mobile-menu-divider">
            @auth
            <a href="{{ route('announcements.index') }}" class="mobile-menu-link" style="color:#F59E0B;" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Ver Anúncios
            </a>
            @else
            <a href="{{ route('login') }}" class="mobile-menu-link" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Fazer Login
            </a>
            <a href="{{ route('register') }}" class="mobile-menu-link" style="color:#F59E0B;" @click="mobileMenuOpen = false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Cadastre-se
            </a>
            @endauth
        </div>
    </div>
</nav>

{{-- ═══ HERO ═══ --}}
<section id="hero-section" style="background:#111;position:relative;overflow:hidden;display:flex;align-items:center;" class="min-h-[60vh] sm:min-h-[75vh] desktop:min-h-[85vh] py-12 sm:py-0">
    {{-- Interactive particle canvas --}}
    <canvas id="heroCanvas" style="position:absolute;inset:0;width:100%;height:100%;z-index:0;pointer-events:none;"></canvas>

    {{-- Ambient glow orbs (CSS only, behind content) --}}
    <div class="hero-glow hero-glow--1"></div>
    <div class="hero-glow hero-glow--2"></div>
    <div class="hero-glow hero-glow--3"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 w-full" style="position:relative;z-index:2;">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 desktop:gap-12 items-center">
            <div id="heroContent">
                <h1 class="hero-anim-item text-2xl sm:text-3xl desktop:text-5xl font-extrabold leading-tight mb-5" style="opacity:0;transform:translateY(30px);color:#F59E0B;">
                    Conectando músicos e estabelecimentos em um só lugar
                </h1>
                <p class="hero-anim-item text-sm sm:text-base mb-8" style="opacity:0;transform:translateY(30px);color:#9CA3AF;max-width:480px;">
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
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="hero-anim-item flex flex-col sm:flex-row gap-3 max-w-md" style="opacity:0;transform:translateY(30px);">
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
                <p class="hero-anim-item text-xs mt-3" style="opacity:0;transform:translateY(30px);color:#555;">
                    Ao criar uma conta, você confirma que aceita nossos
                    <a href="#" style="color:#F59E0B;">Termos e Condições</a>.
                </p>
            </div>
            <div style="position:relative;z-index:1;" class="flex items-center justify-center">
                <img src="{{ asset('assets/band.svg') }}" alt="band" class="w-full h-full object-cover" style="z-index:1;">
            </div>
            <div id="heroVisual" style="opacity:0;transform:translateY(40px) scale(0.95);">
                <div class="hero-visual-container">
                    {{-- Animated equalizer bars --}}
                    <div class="hero-equalizer">
                        <div class="eq-bar" style="--delay:0s;--h:60%;"></div>
                        <div class="eq-bar" style="--delay:0.15s;--h:80%;"></div>
                        <div class="eq-bar" style="--delay:0.3s;--h:45%;"></div>
                        <div class="eq-bar" style="--delay:0.05s;--h:90%;"></div>
                        <div class="eq-bar" style="--delay:0.25s;--h:55%;"></div>
                        <div class="eq-bar" style="--delay:0.1s;--h:75%;"></div>
                        <div class="eq-bar" style="--delay:0.35s;--h:65%;"></div>
                        <div class="eq-bar" style="--delay:0.2s;--h:85%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Hero Particle Animation Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ─── GSAP entrance animations ───
    if (typeof gsap !== 'undefined') {
        const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

        tl.to('.hero-anim-item', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            stagger: 0.12,
        })
        .to('#heroVisual', {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: 1,
            ease: 'elastic.out(1, 0.75)',
        }, '-=0.5')
        .to('.hero-stat', {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: 0.6,
            stagger: 0.15,
            ease: 'back.out(1.7)',
        }, '-=0.4');
    } else {
        // Fallback if GSAP doesn't load
        document.querySelectorAll('.hero-anim-item').forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        });
        const vis = document.getElementById('heroVisual');
        if (vis) { vis.style.opacity = '1'; vis.style.transform = 'none'; }
    }

    // ─── PARTICLE CANVAS ───
    const canvas = document.getElementById('heroCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const section = document.getElementById('hero-section');

    let W, H;
    let mouse = { x: -9999, y: -9999, active: false };
    const PARTICLE_COUNT = 70;
    const CONNECTION_DIST = 140;
    const MOUSE_RADIUS = 180;
    const particles = [];

    function resize() {
        const rect = section.getBoundingClientRect();
        W = rect.width;
        H = rect.height;
        canvas.width = W * window.devicePixelRatio;
        canvas.height = H * window.devicePixelRatio;
        ctx.setTransform(window.devicePixelRatio, 0, 0, window.devicePixelRatio, 0, 0);
    }

    // Musical note shapes
    const SHAPES = ['circle', 'ring', 'diamond', 'note'];

    class Particle {
        constructor() {
            this.reset();
        }
        reset() {
            this.x = Math.random() * W;
            this.y = Math.random() * H;
            this.baseX = this.x;
            this.baseY = this.y;
            this.vx = (Math.random() - 0.5) * 0.4;
            this.vy = (Math.random() - 0.5) * 0.4;
            this.size = Math.random() * 3 + 1.5;
            this.shape = SHAPES[Math.floor(Math.random() * SHAPES.length)];
            this.alpha = Math.random() * 0.5 + 0.2;
            this.baseAlpha = this.alpha;
            this.pulseSpeed = Math.random() * 0.02 + 0.008;
            this.pulsePhase = Math.random() * Math.PI * 2;
            // Gold-amber color palette
            const hue = 35 + Math.random() * 20; // 35-55 range (gold to amber)
            const sat = 80 + Math.random() * 20;
            const light = 55 + Math.random() * 15;
            this.color = `hsla(${hue}, ${sat}%, ${light}%, `;
        }
        update(time) {
            // Organic floating movement
            this.x += this.vx + Math.sin(time * 0.001 + this.pulsePhase) * 0.15;
            this.y += this.vy + Math.cos(time * 0.0008 + this.pulsePhase) * 0.12;

            // Pulse alpha
            this.alpha = this.baseAlpha + Math.sin(time * this.pulseSpeed + this.pulsePhase) * 0.15;

            // Mouse repulsion
            if (mouse.active) {
                const dx = this.x - mouse.x;
                const dy = this.y - mouse.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < MOUSE_RADIUS) {
                    const force = (MOUSE_RADIUS - dist) / MOUSE_RADIUS;
                    const angle = Math.atan2(dy, dx);
                    this.x += Math.cos(angle) * force * 5;
                    this.y += Math.sin(angle) * force * 5;
                    // Boost glow near cursor
                    this.alpha = Math.min(1, this.alpha + force * 0.5);
                }
            }

            // Wrap around edges
            if (this.x < -20) this.x = W + 20;
            if (this.x > W + 20) this.x = -20;
            if (this.y < -20) this.y = H + 20;
            if (this.y > H + 20) this.y = -20;
        }
        draw() {
            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.fillStyle = this.color + this.alpha + ')';

            switch(this.shape) {
                case 'circle':
                    ctx.beginPath();
                    ctx.arc(0, 0, this.size, 0, Math.PI * 2);
                    ctx.fill();
                    break;
                case 'ring':
                    ctx.strokeStyle = this.color + this.alpha * 0.8 + ')';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.arc(0, 0, this.size * 1.5, 0, Math.PI * 2);
                    ctx.stroke();
                    break;
                case 'diamond':
                    ctx.beginPath();
                    const s = this.size * 1.2;
                    ctx.moveTo(0, -s);
                    ctx.lineTo(s, 0);
                    ctx.lineTo(0, s);
                    ctx.lineTo(-s, 0);
                    ctx.closePath();
                    ctx.fill();
                    break;
                case 'note':
                    // Simple music note ♪
                    ctx.fillStyle = this.color + this.alpha + ')';
                    ctx.beginPath();
                    ctx.arc(0, 0, this.size * 0.9, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.strokeStyle = this.color + this.alpha * 0.7 + ')';
                    ctx.lineWidth = 1.2;
                    ctx.beginPath();
                    ctx.moveTo(this.size * 0.9, 0);
                    ctx.lineTo(this.size * 0.9, -this.size * 3);
                    ctx.stroke();
                    // Flag
                    ctx.beginPath();
                    ctx.moveTo(this.size * 0.9, -this.size * 3);
                    ctx.quadraticCurveTo(this.size * 2.5, -this.size * 2.5, this.size * 0.9, -this.size * 1.8);
                    ctx.stroke();
                    break;
            }

            // Glow effect for close-to-mouse particles
            if (mouse.active) {
                const dx = this.x - mouse.x;
                const dy = this.y - mouse.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < MOUSE_RADIUS * 0.7) {
                    const intensity = 1 - dist / (MOUSE_RADIUS * 0.7);
                    ctx.shadowColor = `rgba(245, 158, 11, ${intensity * 0.6})`;
                    ctx.shadowBlur = 15 * intensity;
                    ctx.beginPath();
                    ctx.arc(0, 0, this.size * 0.5, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.shadowBlur = 0;
                }
            }

            ctx.restore();
        }
    }

    function drawConnections(time) {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < CONNECTION_DIST) {
                    let alpha = (1 - dist / CONNECTION_DIST) * 0.15;

                    // Boost connection near mouse
                    if (mouse.active) {
                        const mx = (particles[i].x + particles[j].x) / 2;
                        const my = (particles[i].y + particles[j].y) / 2;
                        const mdx = mx - mouse.x;
                        const mdy = my - mouse.y;
                        const mDist = Math.sqrt(mdx * mdx + mdy * mdy);
                        if (mDist < MOUSE_RADIUS) {
                            alpha += (1 - mDist / MOUSE_RADIUS) * 0.25;
                        }
                    }

                    ctx.strokeStyle = `rgba(245, 158, 11, ${alpha})`;
                    ctx.lineWidth = 0.6;
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
    }

    // Draw concentric rings around cursor
    function drawCursorRings(time) {
        if (!mouse.active) return;
        for (let i = 0; i < 3; i++) {
            const radius = 30 + i * 35 + Math.sin(time * 0.003 + i) * 10;
            const alpha = 0.08 - i * 0.02;
            ctx.strokeStyle = `rgba(245, 158, 11, ${Math.max(alpha, 0.01)})`;
            ctx.lineWidth = 0.8;
            ctx.beginPath();
            ctx.arc(mouse.x, mouse.y, radius, 0, Math.PI * 2);
            ctx.stroke();
        }
    }

    function animate(time) {
        ctx.clearRect(0, 0, W, H);

        drawCursorRings(time);
        drawConnections(time);

        for (const p of particles) {
            p.update(time);
            p.draw();
        }

        requestAnimationFrame(animate);
    }

    // Initialize
    resize();
    for (let i = 0; i < PARTICLE_COUNT; i++) {
        particles.push(new Particle());
    }

    // Mouse tracking (relative to section)
    section.addEventListener('mousemove', (e) => {
        const rect = section.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
        mouse.active = true;
        canvas.style.pointerEvents = 'none';
    });

    section.addEventListener('mouseleave', () => {
        mouse.active = false;
    });

    window.addEventListener('resize', () => {
        resize();
        // Redistribute particles
        particles.forEach(p => {
            if (p.x > W) p.x = Math.random() * W;
            if (p.y > H) p.y = Math.random() * H;
        });
    });

    requestAnimationFrame(animate);
});
</script>

{{-- ═══ COMO FUNCIONA – Músicos ═══ --}}
<section id="quem-somos" class="py-16" style="background:#111;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <p class="text-xs font-semibold mb-2" style="color:#9CA3AF;">Para músicos</p>
        <h2 class="text-2xl sm:text-3xl font-bold mb-8">Como Funciona</h2>

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
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <p class="text-xs font-semibold mb-2" style="color:#9CA3AF;">Para estabelecimentos</p>
        <h2 class="text-2xl sm:text-3xl font-bold mb-8">Como Funciona</h2>

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
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <h2 class="text-3xl sm:text-4xl desktop:text-5xl font-extrabold mb-4" style="color:#F59E0B;">
            Transforme talento em oportunidade.
        </h2>
        <p class="text-sm sm:text-base mb-12" style="color:#9CA3AF;">
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
        <div class="grid grid-cols-2 sm:grid-cols-3 desktop:grid-cols-4 auto-rows-[100px] sm:auto-rows-[120px] desktop:auto-rows-[140px] gap-2 sm:gap-3">
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
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
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
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <h2 class="text-3xl sm:text-4xl font-bold text-center mb-4">Processo</h2>
        <p class="text-center text-sm mb-16" style="color:#9CA3AF;">
            Do cadastro ao palco em poucos passos. Veja como é simples conectar talento e oportunidade.
        </p>

        <div class="relative" id="timeline-container">
            {{-- Background track --}}
            <div class="absolute left-4 sm:left-1/2 top-0 bottom-0 w-px" style="background:#2a2a2a;transform:translateX(-50%);"></div>
            {{-- Animated fill line --}}
            <div class="absolute left-4 sm:left-1/2 top-0 w-px" id="timeline-progress"
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
            <div class="timeline-step flex items-start mb-12 sm:mb-20 relative
                {{ $step['side'] === 'right' ? 'sm:flex-row-reverse' : '' }}"
                 data-side="{{ $step['side'] }}"
                 style="opacity:0;transform:translateY(40px);transition:opacity 0.6s ease {{ $i * 0.15 }}s, transform 0.6s ease {{ $i * 0.15 }}s;">

                {{-- Center dot with number --}}
                <div class="absolute left-4 sm:left-1/2 top-1 z-20 flex items-center justify-center"
                     style="transform:translateX(-50%);">
                    <div class="timeline-dot w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center"
                         style="background:#1a1a1a;border:2px solid #2a2a2a;transition:border-color 0.4s ease, box-shadow 0.4s ease;">
                        <span class="text-xs font-bold" style="color:#F59E0B;">0{{ $i + 1 }}</span>
                    </div>
                </div>

                {{-- Content card --}}
                <div class="w-full pl-12 sm:pl-0 sm:w-5/12 {{ $step['side'] === 'right' ? 'sm:pl-12' : 'sm:pr-12 sm:text-right' }}">
                    <div class="timeline-card p-4 sm:p-5 rounded-lg"
                         style="background:#1a1a1a;border:1px solid #2a2a2a;transition:border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;"
                         onmouseenter="this.style.borderColor='#F59E0B';this.style.boxShadow='0 8px 30px rgba(245,158,11,0.12)';this.style.transform='translateY(-3px)';"
                         onmouseleave="this.style.borderColor='#2a2a2a';this.style.boxShadow='none';this.style.transform='translateY(0)';">
                        <div class="{{ $step['side'] === 'right' ? '' : 'sm:flex sm:flex-col sm:items-end' }}">
                            <div class="w-9 h-9 rounded-md flex items-center justify-center mb-3"
                                 style="background:rgba(245,158,11,0.1);">
                                <svg class="w-5 h-5" style="color:#F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold mb-2" style="color:#F59E0B;">{{ $step['title'] }}</h3>
                        <p class="text-sm leading-relaxed" style="color:#9CA3AF;">{{ $step['desc'] }}</p>
                    </div>
                </div>
                <div class="hidden sm:block sm:w-5/12"></div>
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
