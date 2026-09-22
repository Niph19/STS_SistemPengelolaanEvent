<x-layouts.dashboard :title="'Event'">

<div class="space-y-5">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div></div>
        <a href="{{ route('pengelola.events.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Event
        </a>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('pengelola.events.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ink-muted pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama event..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-navy-surface border border-navy-border text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
        </div>
        <select name="status"
                class="px-4 py-2.5 rounded-xl bg-navy-surface border border-navy-border text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30"
                onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="upcoming"  @selected(request('status') === 'upcoming')>Akan Datang</option>
            <option value="ongoing"   @selected(request('status') === 'ongoing')>Berlangsung</option>
            <option value="completed" @selected(request('status') === 'completed')>Selesai</option>
            <option value="canceled"  @selected(request('status') === 'canceled')>Dibatalkan</option>
        </select>
        <select name="category_id"
                class="px-4 py-2.5 rounded-xl bg-navy-surface border border-navy-border text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30"
                onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories ?? [] as $cat)
                <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-5 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">Cari</button>
    </form>

    {{-- Table --}}
    @if(isset($events) && $events->count())
        {{-- Mobile Cards --}}
        <div class="space-y-3 lg:hidden">
            @foreach($events as $event)
                @php
                    $statusMap = [
                        'upcoming'  => ['label' => 'Akan Datang', 'bg' => 'bg-blue-500/10',    'text' => 'text-blue-300'],
                        'ongoing'   => ['label' => 'Berlangsung', 'bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-300'],
                        'completed' => ['label' => 'Selesai',     'bg' => 'bg-ink-muted/20',   'text' => 'text-ink-muted'],
                        'canceled'  => ['label' => 'Dibatalkan',  'bg' => 'bg-red-500/10',     'text' => 'text-red-300'],
                    ];
                    $st = $statusMap[$event->status] ?? $statusMap['upcoming'];
                @endphp
                <div class="p-4 rounded-xl bg-navy-surface border border-navy-border">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-ink-primary truncate">{{ $event->title }}</p>
                            <p class="text-xs text-ink-muted mt-0.5">{{ $event->category->name ?? '—' }} • {{ $event->start_date->isoFormat('D MMM YYYY') }}</p>
                        </div>
                        <span class="shrink-0 text-xs px-2.5 py-1 rounded-full {{ $st['bg'] }} {{ $st['text'] }}">{{ $st['label'] }}</span>
                    </div>
                    <p class="text-xs text-ink-muted mb-3">{{ $event->registrations_count ?? 0 }}/{{ $event->capacity }} peserta</p>
                    <div class="flex items-center gap-3 text-xs">
                        <a href="{{ route('pengelola.events.show', $event) }}" class="text-ink-secondary hover:text-coral transition-colors">Detail</a>
                        <a href="{{ route('pengelola.events.edit', $event) }}" class="text-ink-secondary hover:text-coral transition-colors">Edit</a>
                        <a href="{{ route('pengelola.events.registrations', $event) }}" class="text-ink-secondary hover:text-coral transition-colors">Peserta</a>
                        <form method="POST" action="{{ route('pengelola.events.destroy', $event) }}" class="inline" onsubmit="return confirm('Hapus event ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Desktop Table --}}
        <div class="hidden lg:block overflow-x-auto rounded-xl border border-navy-border">
            <table class="w-full text-sm text-left">
                <thead class="bg-navy-surface text-xs text-ink-muted uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Judul</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Peserta</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-border">
                    @foreach($events as $event)
                        @php $st = $statusMap[$event->status] ?? $statusMap['upcoming']; @endphp
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-5 py-4 font-medium text-ink-primary max-w-xs truncate">{{ $event->title }}</td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $event->category->name ?? '—' }}</td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $event->start_date->isoFormat('D MMM YYYY') }}</td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $event->registrations_count ?? 0 }}/{{ $event->capacity }}</td>
                            <td class="px-5 py-4">
                                <span class="text-xs px-2.5 py-1 rounded-full {{ $st['bg'] }} {{ $st['text'] }}">{{ $st['label'] }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('pengelola.events.show', $event) }}" class="text-ink-secondary hover:text-coral transition-colors text-xs">Detail</a>
                                    <a href="{{ route('pengelola.events.edit', $event) }}" class="text-ink-secondary hover:text-coral transition-colors text-xs">Edit</a>
                                    <a href="{{ route('pengelola.events.registrations', $event) }}" class="text-ink-secondary hover:text-coral transition-colors text-xs">Peserta</a>
                                    <form method="POST" action="{{ route('pengelola.events.destroy', $event) }}" class="inline" onsubmit="return confirm('Hapus event ini?')">
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

        @if($events->hasPages())
            <div class="mt-4">{{ $events->links() }}</div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center py-16 rounded-xl bg-navy-surface border border-navy-border border-dashed">
            <svg class="w-10 h-10 text-ink-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm text-ink-muted mb-3">Belum ada event</p>
            <a href="{{ route('pengelola.events.create') }}" class="text-sm text-coral hover:underline">Buat event baru</a>
        </div>
    @endif
</div>

</x-layouts.dashboard>
