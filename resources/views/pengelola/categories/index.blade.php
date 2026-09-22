<x-layouts.dashboard :title="'Kategori'">

<div class="space-y-5">
    {{-- Header --}}
    <div class="flex justify-end">
        <a href="{{ route('pengelola.categories.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kategori
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('pengelola.categories.index') }}" class="flex gap-3">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ink-muted pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-navy-surface border border-navy-border text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">Cari</button>
    </form>

    {{-- Table --}}
    @if(isset($categories) && $categories->count())
        <div class="overflow-x-auto rounded-xl border border-navy-border">
            <table class="w-full text-sm text-left">
                <thead class="bg-navy-surface text-xs text-ink-muted uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Nama Kategori</th>
                        <th class="px-5 py-3">Jumlah Event</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-border">
                    @foreach($categories as $cat)
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-5 py-4 font-medium text-ink-primary">{{ $cat->name }}</td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $cat->events_count ?? 0 }} event</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('pengelola.categories.edit', $cat) }}" class="text-ink-secondary hover:text-coral transition-colors text-xs">Edit</a>
                                    <form method="POST" action="{{ route('pengelola.categories.destroy', $cat) }}" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline text-xs">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="mt-4">{{ $categories->links() }}</div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center py-16 rounded-xl bg-navy-surface border border-navy-border border-dashed">
            <svg class="w-10 h-10 text-ink-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <p class="text-sm text-ink-muted mb-3">Belum ada kategori</p>
            <a href="{{ route('pengelola.categories.create') }}" class="text-sm text-coral hover:underline">Tambah kategori</a>
        </div>
    @endif
</div>

</x-layouts.dashboard>
