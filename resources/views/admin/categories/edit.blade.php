<x-layouts.dashboard :title="'Edit Kategori'">

<div class="max-w-lg">
    {{-- Back --}}
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 text-sm text-ink-secondary hover:text-ink-primary mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar Kategori
    </a>

    <div class="p-6 rounded-2xl bg-navy-surface border border-navy-border">
        <h2 class="text-base font-semibold text-ink-primary mb-1">Edit Kategori</h2>
        <p class="text-sm text-ink-muted mb-6">Mengubah nama kategori akan memengaruhi semua event yang terkait.</p>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5">
            @csrf
            @method('PATCH')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-ink-primary mb-1.5">Nama Kategori</label>
                <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1
                              {{ $errors->has('name') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-navy-border focus:border-coral/50 focus:ring-coral/20' }}"
                       placeholder="Nama kategori...">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Info --}}
            @if(isset($category->events_count) && $category->events_count > 0)
                <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-300 text-xs">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Kategori ini digunakan oleh {{ $category->events_count }} event.
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                        class="px-5 py-2.5 bg-coral hover:bg-coral-hover text-white font-semibold text-sm rounded-xl transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-ink-primary font-medium text-sm rounded-xl transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

</x-layouts.dashboard>
