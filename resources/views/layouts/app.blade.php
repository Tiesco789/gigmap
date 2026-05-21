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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>

{{-- Navbar (authenticated) --}}
<nav class="navbar">
    <div class="max-w-6xl mx-auto px-6 flex items-center h-14 gap-8">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/logo-gigmap.svg') }}" width="120"  />
        </a>

        {{-- Nav links --}}
        <div class="hidden md:flex items-center gap-7 flex-1">
            <a href="{{ route('announcements.index') }}" class="btn-ghost text-sm">Anúncios</a>
            <a href="{{ route('home') }}#quem-somos" class="btn-ghost text-sm">Quem Somos</a>
            <a href="{{ route('home') }}#sobre" class="btn-ghost text-sm">Sobre o Projeto</a>
        </div>

        {{-- Search + user menu --}}
        <div class="flex items-center gap-3 ml-auto">
            <form action="{{ route('announcements.index') }}" method="GET" class="hidden md:flex items-center relative" id="searchForm" autocomplete="off">
                <div class="flex items-center border border-amber-500 rounded px-3 py-1.5 gap-2" style="background:#1a1a1a;">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Buscar..."
                        class="bg-transparent text-sm text-gray-200 outline-none w-40 placeholder-gray-500" autocomplete="off">
                </div>

                {{-- Autocomplete dropdown --}}
                <div id="searchDropdown" class="hidden absolute left-0 right-0 mt-1 rounded-lg shadow-2xl z-[60] overflow-hidden"
                    style="background:#1c1c1c; border:1px solid #333; top:100%; min-width:280px;">
                    <div id="searchResults"></div>
                </div>
            </form>

            {{-- Chat icon --}}
            @php $chatUnreadCount = auth()->user()->totalUnreadMessages(); @endphp
            <a href="{{ route('chats.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/5 transition-colors relative" title="Mensagens" id="chatNavLink">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                @if($chatUnreadCount > 0)
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full text-[10px] font-bold flex items-center justify-center" style="background:#ef4444;color:#fff;">
                        {{ $chatUnreadCount > 9 ? '9+' : $chatUnreadCount }}
                    </span>
                @endif
            </a>

            {{-- Bell (notifications) --}}
            <div class="relative" id="notificationWrapper">
                <button id="notificationBell" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/5 transition-colors relative">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="notificationBadge" class="hidden absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full text-[10px] font-bold flex items-center justify-center" style="background:#ef4444;color:#fff;"></span>
                </button>

                {{-- Notification dropdown --}}
                <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 rounded-md shadow-xl z-50 overflow-hidden" style="background:#1c1c1c; border:1px solid #333;">
                    <div class="flex items-center justify-between px-4 py-3" style="border-bottom:1px solid #333;">
                        <span class="text-sm font-bold" style="color:#F59E0B;">Notificações</span>
                        <button id="markAllReadBtn" class="text-xs hover:underline" style="color:#F59E0B;">Marcar todas como lidas</button>
                    </div>
                    <div id="notificationList" class="max-h-72 overflow-y-auto">
                        <div class="px-4 py-6 text-center text-sm" style="color:#9CA3AF;">Carregando...</div>
                    </div>
                </div>
            </div>

            {{-- Avatar dropdown --}}
            <div class="relative" id="avatarWrapper">
                <button id="avatarBtn" class="w-9 h-9 rounded-full overflow-hidden border-2 border-amber-500 flex items-center justify-center"
                    style="background:#2a2a2a;">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->getAvatarUrl() }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    @endif
                </button>
                <div id="avatarMenu" class="hidden absolute right-0 mt-2 w-44 rounded-md shadow-xl py-1 z-50"
                    style="background:#1c1c1c; border:1px solid #333;">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-amber-400 hover:bg-white/5 transition-colors">
                        Meu Perfil
                    </a>
                    <a href="{{ route('profile.show', auth()->user()) }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-amber-400 hover:bg-white/5 transition-colors">
                        Perfil Público
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
document.addEventListener('DOMContentLoaded', () => {
    // ─── Avatar dropdown toggle ───
    const avatarBtn = document.getElementById('avatarBtn');
    const avatarMenu = document.getElementById('avatarMenu');
    if (avatarBtn && avatarMenu) {
        avatarBtn.addEventListener('click', () => {
            avatarMenu.classList.toggle('hidden');
            // Close notification dropdown when opening avatar
            document.getElementById('notificationDropdown')?.classList.add('hidden');
        });
    }

    // ─── Notification bell ───
    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    const badge = document.getElementById('notificationBadge');
    const list = document.getElementById('notificationList');
    const markAllBtn = document.getElementById('markAllReadBtn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
        || '{{ csrf_token() }}';

    function loadNotifications() {
        fetch('/notificacoes', { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => {
                // Update badge
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count > 9 ? '9+' : data.unread_count;
                    badge.classList.remove('hidden');
                    badge.classList.add('flex');
                } else {
                    badge.classList.add('hidden');
                    badge.classList.remove('flex');
                }

                // Render notifications
                if (data.notifications.length === 0) {
                    list.innerHTML = '<div class="px-4 py-6 text-center text-sm" style="color:#9CA3AF;">Nenhuma notificação</div>';
                    return;
                }

                list.innerHTML = data.notifications.map(n => {
                    const isUnread = !n.read_at;
                    const d = n.data;
                    return `
                        <div class="px-4 py-3 cursor-pointer transition-colors hover:bg-white/5 ${isUnread ? '' : 'opacity-60'}"
                            style="border-bottom:1px solid #2a2a2a;"
                            data-notification-id="${n.id}"
                            ${isUnread ? 'data-unread="true"' : ''}>
                            <p class="text-sm font-semibold mb-0.5" style="color:#F59E0B;">${d.sender_name}</p>
                            <p class="text-xs mb-1" style="color:#d1d5db;">
                                Enviou uma proposta para <strong>${d.announcement_title}</strong>
                            </p>
                            ${d.message ? `<p class="text-xs line-clamp-2" style="color:#9CA3AF;">"${d.message}"</p>` : ''}
                            <p class="text-xs mt-1" style="color:#666;">${n.time_ago}</p>
                        </div>
                    `;
                }).join('');

                // Click on notification → mark as read & go to announcement
                list.querySelectorAll('[data-notification-id]').forEach(el => {
                    el.addEventListener('click', () => {
                        const id = el.dataset.notificationId;
                        const announcementId = data.notifications.find(n => n.id === id)?.data.announcement_id;
                        if (el.dataset.unread) {
                            fetch(`/notificacoes/${id}/lida`, {
                                method: 'POST',
                                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                            });
                        }
                        if (announcementId) {
                            window.location.href = `/anuncios/${announcementId}`;
                        }
                    });
                });
            })
            .catch(() => {
                list.innerHTML = '<div class="px-4 py-6 text-center text-sm" style="color:#9CA3AF;">Erro ao carregar</div>';
            });
    }

    if (bell && dropdown) {
        bell.addEventListener('click', () => {
            const isHidden = dropdown.classList.contains('hidden');
            dropdown.classList.toggle('hidden');
            avatarMenu?.classList.add('hidden');
            if (isHidden) loadNotifications();
        });
    }

    // Mark all as read
    if (markAllBtn) {
        markAllBtn.addEventListener('click', () => {
            fetch('/notificacoes/todas-lidas', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            }).then(() => loadNotifications());
        });
    }

    // Close dropdowns on outside click
    document.addEventListener('click', (e) => {
        if (!document.getElementById('notificationWrapper')?.contains(e.target)) {
            dropdown?.classList.add('hidden');
        }
        if (!document.getElementById('avatarWrapper')?.contains(e.target)) {
            avatarMenu?.classList.add('hidden');
        }
        if (!document.getElementById('searchForm')?.contains(e.target)) {
            document.getElementById('searchDropdown')?.classList.add('hidden');
        }
    });

    // Load badge count on page load
    loadNotifications();

    // ─── Search Autocomplete ───
    const searchInput    = document.getElementById('searchInput');
    const searchDropdown = document.getElementById('searchDropdown');
    const searchResults  = document.getElementById('searchResults');

    if (searchInput && searchDropdown && searchResults) {
        let debounceTimer = null;
        let abortController = null;
        let activeIndex = -1;

        function showDropdown() { searchDropdown.classList.remove('hidden'); }
        function hideDropdown() { searchDropdown.classList.add('hidden'); activeIndex = -1; }

        function highlightItem(index) {
            const items = searchResults.querySelectorAll('[data-ac-item]');
            items.forEach((el, i) => {
                el.style.background = i === index ? 'rgba(245,158,11,0.12)' : 'transparent';
            });
            activeIndex = index;
        }

        function renderResults(musicians) {
            if (musicians.length === 0) {
                searchResults.innerHTML = `
                    <div class="px-4 py-5 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" style="color:#555;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <p class="text-sm" style="color:#9CA3AF;">Nenhum resultado encontrado</p>
                    </div>`;
                showDropdown();
                return;
            }

            const badgeColor = (type) => type === 'musician'
                ? 'background:rgba(245,158,11,0.15);color:#F59E0B;'
                : 'background:rgba(99,102,241,0.15);color:#818cf8;';

            searchResults.innerHTML = musicians.map((m, i) => `
                <a href="${m.url}" data-ac-item="${i}"
                    class="flex items-center gap-3 px-4 py-2.5 transition-colors"
                    style="border-bottom:1px solid #2a2a2a; text-decoration:none;">
                    <img src="${m.avatar}" alt="${m.name}"
                        class="w-8 h-8 rounded-full object-cover flex-shrink-0"
                        style="border:1.5px solid ${m.type === 'musician' ? '#F59E0B' : '#818cf8'};"
                        onerror="this.style.display='none'">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 mb-0.5">
                            <p class="text-sm font-semibold truncate" style="color:#e5e7eb;">${m.name}</p>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded flex-shrink-0" style="${badgeColor(m.type)}">${m.label}</span>
                        </div>
                        ${m.subtitle ? `<p class="text-xs truncate" style="color:#9CA3AF;">${m.subtitle}</p>` : ''}
                    </div>
                    <svg class="w-4 h-4 flex-shrink-0" style="color:#555;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            `).join('');

            // Hover highlight
            searchResults.querySelectorAll('[data-ac-item]').forEach((el, i) => {
                el.addEventListener('mouseenter', () => highlightItem(i));
                el.addEventListener('mouseleave', () => { el.style.background = 'transparent'; activeIndex = -1; });
            });

            showDropdown();
        }

        function fetchResults(query) {
            if (abortController) abortController.abort();
            abortController = new AbortController();

            searchResults.innerHTML = `
                <div class="px-4 py-4 text-center">
                    <div class="inline-block w-5 h-5 border-2 rounded-full animate-spin" style="border-color:#F59E0B transparent #F59E0B transparent;"></div>
                </div>`;
            showDropdown();

            fetch(`/api/buscar?q=${encodeURIComponent(query)}`, {
                signal: abortController.signal,
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => renderResults(data))
            .catch(err => {
                if (err.name !== 'AbortError') {
                    hideDropdown();
                }
            });
        }

        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim();
            if (q.length < 3) {
                hideDropdown();
                if (abortController) abortController.abort();
                return;
            }
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchResults(q), 300);
        });

        // Keyboard navigation
        searchInput.addEventListener('keydown', (e) => {
            if (searchDropdown.classList.contains('hidden')) return;
            const items = searchResults.querySelectorAll('[data-ac-item]');
            if (!items.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                highlightItem(activeIndex < items.length - 1 ? activeIndex + 1 : 0);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                highlightItem(activeIndex > 0 ? activeIndex - 1 : items.length - 1);
            } else if (e.key === 'Enter' && activeIndex >= 0) {
                e.preventDefault();
                items[activeIndex].click();
            } else if (e.key === 'Escape') {
                hideDropdown();
                searchInput.blur();
            }
        });

        // Hide on blur (with small delay for click events on items)
        searchInput.addEventListener('blur', () => {
            setTimeout(() => hideDropdown(), 200);
        });

        // Re-show on focus if there's enough text
        searchInput.addEventListener('focus', () => {
            if (searchInput.value.trim().length >= 3 && searchResults.innerHTML.trim()) {
                showDropdown();
            }
        });
    }
});
</script>
</body>
</html>
