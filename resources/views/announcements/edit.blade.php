@extends('layouts.app')

@section('title', 'Editar Anúncio')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 animate-fade-in-up">

    <div class="mb-6">
        <h1 class="text-2xl font-bold" style="color:#F59E0B;">Editar Anúncio</h1>
        <p class="text-sm mt-1" style="color:#9CA3AF;">Atualize as informações do seu anúncio.</p>
    </div>

    <form method="POST" action="{{ route('announcements.update', $announcement) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Image --}}
        <div class="form-section">
            <div class="form-section-label">Imagem do anuncio</div>
            <div class="flex items-center gap-4">
                <div id="imgPreview" class="w-20 h-20 overflow-hidden rounded flex items-center justify-center" style="background:#2a2a2a;border:2px solid #333;">
                    @if($announcement->image)
                        <img src="{{ $announcement->getImageUrl() }}" alt="Imagem" class="w-full h-full object-cover">
                    @else
                        <svg class="w-7 h-7" style="color:#555;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>
                <button type="button" class="btn-outline-gold text-sm" style="padding:0.4rem 1rem;" onclick="document.getElementById('imgInput').click()">
                    Upload photo
                </button>
                <input type="file" id="imgInput" name="image" class="hidden" accept="image/*">
            </div>
        </div>

        {{-- Title --}}
        <div class="form-section">
            <div class="form-section-label">Título</div>
            <input type="text" name="title" value="{{ old('title', $announcement->title) }}" class="input-subtle" required>
            @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Description --}}
        <div class="form-section">
            <div class="form-section-label">Descrição</div>
            <div>
                <textarea name="description" id="descTextarea" rows="7" maxlength="500"
                    placeholder="Type your message..."
                    class="input-subtle resize-none w-full">{{ old('description', $announcement->description) }}</textarea>
                <p class="text-xs mt-1" style="color:#9CA3AF;"><span id="descCount">{{ 500 - strlen($announcement->description ?? '') }}</span> characters left</p>
            </div>
        </div>

        {{-- Genre --}}
        <div class="form-section">
            <div class="form-section-label">Gênero musical</div>
            <select name="genre" class="input-subtle" style="max-width:300px;">
                <option value="">Selecione um gênero</option>
                @foreach($genres as $g)
                    <option value="{{ $g }}" {{ old('genre', $announcement->genre) === $g ? 'selected' : '' }}>{{ $g }}</option>
                @endforeach
            </select>
        </div>

        {{-- Price / Location --}}
        <div class="form-section">
            <div class="form-section-label">Valor / Localização</div>
            <div class="space-y-3">
                <input type="number" name="price" value="{{ old('price', $announcement->price) }}" placeholder="R$0000" step="0.01" min="0" class="input-subtle">
                <input type="text" name="location" value="{{ old('location', $announcement->location) }}" placeholder="Av. Nome do Local, 546" class="input-subtle">
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6 pt-4" style="border-top:1px solid #2a2a2a;">
            <a href="{{ route('announcements.show', $announcement) }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-primary">Salvar</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
const textarea = document.getElementById('descTextarea');
const counter = document.getElementById('descCount');
if (textarea && counter) {
    textarea.addEventListener('input', () => {
        counter.textContent = 500 - textarea.value.length;
    });
}
document.getElementById('imgInput')?.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('imgPreview');
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
