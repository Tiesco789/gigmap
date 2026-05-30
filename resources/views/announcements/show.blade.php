@extends('layouts.app')

@section('title', $announcement->title)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12 animate-fade-in-up">

    @if($announcement->isExpired())
    {{-- ══════════ Expired event state ══════════ --}}
    <div class="flex flex-col items-center justify-center text-center py-20">
        {{-- Icon --}}
        <div class="mb-6 rounded-full flex items-center justify-center" style="width:96px;height:96px;background:rgba(239,68,68,0.1);border:2px solid rgba(239,68,68,0.25);">
            <svg class="w-12 h-12" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        {{-- Message --}}
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mb-3" style="color:#ef4444;">Este evento já passou</h1>
        <p class="text-base mb-2" style="color:#9CA3AF;">O evento <strong style="color:#d1d5db;">{{ $announcement->title }}</strong> estava agendado para:</p>
        <p class="text-2xl font-bold mb-6" style="color:#F59E0B;">{{ $announcement->getFormattedEventDate() }}</p>
        <p class="text-sm mb-8" style="color:#6B7280;max-width:480px;">
            Este anúncio não está mais disponível para novas propostas pois a data do evento já expirou.
        </p>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('announcements.index') }}" class="btn-outline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Ver Anúncios Ativos
            </a>
            @if(auth()->id() === $announcement->user_id)
            <form method="POST" action="{{ route('announcements.destroy', $announcement) }}"
                onsubmit="return confirm('Deseja excluir este anúncio expirado?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-outline text-sm" style="color:#ef4444;border-color:#ef4444;">
                    Excluir Anúncio
                </button>
            </form>
            @endif
        </div>
    </div>

    @else
    {{-- ══════════ Active event ══════════ --}}

    {{-- Title + Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold" style="color:#F59E0B;">{{ $announcement->title }}</h1>
        @if(auth()->id() !== $announcement->user_id)
        <div class="flex items-center gap-2 flex-shrink-0">
            {{-- Contact button --}}
            @auth
            @if(auth()->user()->type !== $announcement->user->type)
            <form method="POST" action="{{ route('chats.store') }}" class="inline">
                @csrf
                <input type="hidden" name="recipient_id" value="{{ $announcement->user_id }}">
                <button type="submit" class="btn-outline-gold flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Enviar Mensagem
                </button>
            </form>
            @endif
            @endauth
            <a href="{{ route('reviews.create', $announcement->user) }}" class="btn-primary flex-shrink-0">
                Avaliar Artista
            </a>
        </div>
        @else
        <div class="flex gap-2">
            <a href="{{ route('announcements.edit', $announcement) }}" class="btn-outline-gold flex-shrink-0 text-sm">
                Editar
            </a>
            <form method="POST" action="{{ route('announcements.destroy', $announcement) }}"
                onsubmit="return confirm('Deseja excluir este anúncio?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-outline flex-shrink-0 text-sm" style="color:#ef4444;border-color:#ef4444;">
                    Excluir
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- Meta info --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div>
            <p class="text-xs font-semibold mb-1" style="color:#F59E0B;">Nome do Artista</p>
            <p>{{ $announcement->user->getDisplayName() }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold mb-1" style="color:#F59E0B;">Valor</p>
            <p>{{ $announcement->getFormattedPrice() }}</p>
        </div>
        @if($announcement->location)
        <div>
            <p class="text-xs font-semibold mb-1" style="color:#F59E0B;">Localização</p>
            <p>{{ $announcement->location }}</p>
        </div>
        @endif
        @if($announcement->event_date)
        <div>
            <p class="text-xs font-semibold mb-1" style="color:#F59E0B;">Data do Evento</p>
            <p>{{ $announcement->getFormattedEventDate() }}</p>
        </div>
        @endif
    </div>

    {{-- Image + Description --}}
    <div class="flex flex-col md:flex-row gap-10 mb-10">
        <div class="w-full md:w-80 flex-shrink-0">
            <img src="{{ $announcement->getImageUrl() }}" alt="{{ $announcement->title }}"
                class="w-full rounded-lg object-cover" style="max-height:280px;">
        </div>

        <div class="flex-1">
            <p class="text-sm font-semibold mb-2" style="color:#F59E0B;">Descrição</p>
            <p class="text-sm leading-relaxed" style="color:#d1d5db;">{{ $announcement->description }}</p>
        </div>
    </div>

    {{-- Proposal Form + Contact Card --}}
    @if(auth()->id() !== $announcement->user_id)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Proposal form (takes 2 columns) --}}
        <div class="md:col-span-2 p-6 rounded-lg" style="background:#1a1a1a;border:1px solid #2a2a2a;">
            <h3 class="text-lg font-bold mb-3" style="color:#F59E0B;">Enviar Proposta</h3>
            <form method="POST" action="{{ route('proposals.store', $announcement) }}" id="proposalForm">
                @csrf

                {{-- Monetary value input --}}
                <div class="mb-4">
                    <label for="proposalValue" class="block text-xs font-semibold mb-2" style="color:#9CA3AF;">Valor da Proposta</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold" style="color:#F59E0B;" id="currencyPrefix">R$</span>
                        <input type="text"
                               name="value"
                               id="proposalValue"
                               placeholder="0,00"
                               class="input-monetary"
                               autocomplete="off"
                               inputmode="decimal"
                               value="{{ old('value') }}">
                    </div>
                    @error('value')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Negotiate checkbox --}}
                <div class="mb-5">
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <input type="checkbox"
                               name="negotiate"
                               value="1"
                               id="negotiateCheck"
                               class="w-4 h-4 rounded accent-amber-500 cursor-pointer"
                               {{ old('negotiate') ? 'checked' : '' }}>
                        <span class="text-sm group-hover:text-amber-400 transition-colors" style="color:#d1d5db;">
                            Prefiro negociar o valor
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn-primary" id="proposalSubmitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Enviar Proposta
                </button>
            </form>
        </div>

        {{-- Contact card (1 column) --}}
        @auth
        @if(auth()->user()->type !== $announcement->user->type)
        <div class="p-6 rounded-lg flex flex-col items-center text-center" style="background:#1a1a1a;border:1px solid #2a2a2a;">
            {{-- Author avatar --}}
            <img src="{{ $announcement->user->getAvatarUrl() }}" alt="{{ $announcement->user->getDisplayName() }}"
                class="w-16 h-16 rounded-full object-cover mb-3" style="border:2px solid #F59E0B;">
            <p class="text-sm font-bold mb-1">{{ $announcement->user->getDisplayName() }}</p>
            <p class="text-xs mb-4" style="color:#9CA3AF;">{{ ucfirst($announcement->user->type === 'musician' ? 'Músico' : 'Estabelecimento') }}</p>

            <form method="POST" action="{{ route('chats.store') }}" class="w-full">
                @csrf
                <input type="hidden" name="recipient_id" value="{{ $announcement->user_id }}">
                <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Enviar Mensagem
                </button>
            </form>
            <p class="text-xs mt-3" style="color:#6B7280;">Converse diretamente com o autor do anúncio</p>
        </div>
        @endif
        @endauth
    </div>
    @endif

    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const valueInput = document.getElementById('proposalValue');
    const negotiateCheck = document.getElementById('negotiateCheck');
    const currencyPrefix = document.getElementById('currencyPrefix');
    const form = document.getElementById('proposalForm');

    if (!valueInput || !negotiateCheck) return;

    // ── Currency mask (Brazilian format: 1.234,56) ───
    function formatCurrency(value) {
        // Remove everything except digits
        let digits = value.replace(/\D/g, '');
        if (digits === '') return '';
        // Convert to number (cents)
        let num = parseInt(digits, 10);
        // Format as Brazilian currency
        let formatted = (num / 100).toFixed(2)
            .replace('.', ',')
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        return formatted;
    }

    function parseCurrencyToFloat(value) {
        if (!value) return 0;
        // Remove dots (thousands), replace comma with dot (decimal)
        return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
    }

    valueInput.addEventListener('input', () => {
        let pos = valueInput.selectionStart;
        let oldLen = valueInput.value.length;
        valueInput.value = formatCurrency(valueInput.value);
        let newLen = valueInput.value.length;
        // Adjust cursor
        valueInput.setSelectionRange(pos + (newLen - oldLen), pos + (newLen - oldLen));
    });

    // ── Negotiate toggle ───
    function toggleNegotiate() {
        if (negotiateCheck.checked) {
            valueInput.disabled = true;
            valueInput.value = '';
            valueInput.style.opacity = '0.4';
            currencyPrefix.style.opacity = '0.4';
        } else {
            valueInput.disabled = false;
            valueInput.style.opacity = '1';
            currencyPrefix.style.opacity = '1';
            valueInput.focus();
        }
    }

    negotiateCheck.addEventListener('change', toggleNegotiate);
    toggleNegotiate(); // Initial state

    // ── Form validation ───
    form.addEventListener('submit', (e) => {
        if (negotiateCheck.checked) return; // Allow negotiate

        const val = parseCurrencyToFloat(valueInput.value);
        if (val <= 0) {
            e.preventDefault();
            valueInput.style.borderColor = '#ef4444';
            valueInput.focus();
            setTimeout(() => { valueInput.style.borderColor = ''; }, 2000);
        } else {
            // Convert to server-friendly format before submit
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'value';
            hiddenInput.value = val;
            form.appendChild(hiddenInput);
            valueInput.name = ''; // Prevent duplicate
        }
    });
});
</script>
@endpush
@endsection
