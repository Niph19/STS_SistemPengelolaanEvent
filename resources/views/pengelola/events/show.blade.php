<x-layouts.dashboard :title="'Detail Event'">

@php
    $statusMap = [
        'upcoming'  => ['label' => 'Akan Datang', 'bg' => 'bg-blue-500/10',    'text' => 'text-blue-300'],
        'ongoing'   => ['label' => 'Berlangsung', 'bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-300'],
        'completed' => ['label' => 'Selesai',     'bg' => 'bg-ink-muted/20',   'text' => 'text-ink-muted'],
        'canceled'  => ['label' => 'Dibatalkan',  'bg' => 'bg-red-500/10',     'text' => 'text-red-300'],
    ];
    $st = $statusMap[$event->status] ?? $statusMap['upcoming'];
    $filledSlots = $event->registrations_count ?? $event->registrations->count();
    $fillPercent = $event->capacity > 0 ? min(100, round($filledSlots / $event->capacity * 100)) : 0;
@endphp

<div class="space-y-6 max-w-3xl">
    {{-- Actions --}}
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('pengelola.events.edit', $event) }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-navy-surface border border-navy-border hover:border-coral/40 text-ink-secondary hover:text-coral text-sm rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
        <a href="{{ route('pengelola.events.registrations', $event) }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-navy-surface border border-navy-border hover:border-coral/40 text-ink-secondary hover:text-coral text-sm rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Kelola Peserta
        </a>
        <form method="POST" action="{{ route('pengelola.events.destroy', $event) }}" class="inline" onsubmit="return confirm('Hapus event ini?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500/10 border border-red-500/20 hover:border-red-500/40 text-red-400 text-sm rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </form>
    </div>

    {{-- Info Card --}}
    <div class="p-6 rounded-2xl bg-navy-surface border border-navy-border">
        <div class="flex flex-wrap items-center gap-2 mb-3">
            @if($event->category)
                <span class="text-xs px-2.5 py-1 rounded-full bg-coral/10 text-coral border border-coral/20">{{ $event->category->name }}</span>
            @endif
            <span class="text-xs px-2.5 py-1 rounded-full {{ $st['bg'] }} {{ $st['text'] }}">{{ $st['label'] }}</span>
        </div>
        <h2 class="text-xl font-bold text-ink-primary mb-5">{{ $event->title }}</h2>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
            <div>
                <dt class="text-xs text-ink-muted mb-0.5">Tanggal Mulai</dt>
                <dd class="text-sm text-ink-primary">{{ $event->start_date->isoFormat('D MMMM YYYY, HH:mm') }}</dd>
            </div>
            @if($event->end_date)
            <div>
                <dt class="text-xs text-ink-muted mb-0.5">Tanggal Selesai</dt>
                <dd class="text-sm text-ink-primary">{{ $event->end_date->isoFormat('D MMMM YYYY, HH:mm') }}</dd>
            </div>
            @endif
            <div>
                <dt class="text-xs text-ink-muted mb-0.5">Lokasi</dt>
                <dd class="text-sm text-ink-primary">{{ $event->location }}</dd>
            </div>
            <div>
                <dt class="text-xs text-ink-muted mb-0.5">Kapasitas</dt>
                <dd class="text-sm text-ink-primary">{{ $filledSlots }} / {{ $event->capacity }} peserta</dd>
            </div>
        </dl>

        {{-- Capacity bar --}}
        <div class="mb-5">
            <div class="flex justify-between text-xs text-ink-muted mb-1.5">
                <span>Terisi {{ $fillPercent }}%</span>
                <span>{{ $event->capacity - $filledSlots }} sisa</span>
            </div>
            <div class="h-1.5 bg-navy-border rounded-full overflow-hidden">
                <div class="h-full bg-coral rounded-full" style="width: {{ $fillPercent }}%"></div>
            </div>
        </div>

        <div>
            <dt class="text-xs text-ink-muted mb-1">Deskripsi</dt>
            <dd class="text-sm text-ink-secondary leading-relaxed whitespace-pre-line">{{ $event->description }}</dd>
        </div>
    </div>
</div>

</x-layouts.dashboard>
