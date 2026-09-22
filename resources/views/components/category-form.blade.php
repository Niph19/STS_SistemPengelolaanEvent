{{-- Shared category form partial, used by pengelola and admin --}}
@props(['action', 'method' => 'POST', 'category' => null, 'cancelRoute'])

<div class="max-w-md">
    <form method="POST" action="{{ $action }}" class="space-y-5">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        <div>
            <label for="name" class="block text-sm font-medium text-ink-secondary mb-1.5">
                Nama Kategori <span class="text-coral">*</span>
            </label>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $category?->name) }}"
                   placeholder="Contoh: Seminar, Workshop, Lomba..."
                   class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('name') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
            @error('name')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ $cancelRoute }}"
               class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-sm text-ink-secondary transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">
                {{ $category ? 'Perbarui' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
