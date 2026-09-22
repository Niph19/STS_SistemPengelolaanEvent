<x-layouts.dashboard :title="'Dashboard'">

<div class="space-y-6">
    {{-- Welcome --}}
    <div class="p-5 rounded-2xl bg-navy-surface border border-navy-border">
        <p class="text-xs text-ink-muted mb-1">Selamat datang kembali,</p>
        <h2 class="text-lg font-semibold text-ink-primary">{{ auth()->user()->name }}</h2>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $stats = [
                ['label' => 'Total Event',    'value' => $totalEvents ?? 0,        'color' => 'text-coral',       'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['label' => 'Akan Datang',   'value' => $upcomingEvents ?? 0,     'color' => 'text-blue-400',    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Sedang Berjalan', 'value' => $ongoingEvents ?? 0,    'color' => 'text-emerald-400', 'icon' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Total Peserta', 'value' => $totalParticipants ?? 0,  'color' => 'text-purple-400',  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ];
        @endphp
        @foreach($stats as $s)
            <div class="p-4 rounded-xl bg-navy-surface border border-navy-border">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-5 h-5 {{ $s['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $s['icon'] }}"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold {{ $s['color'] }} mb-1">{{ $s['value'] }}</p>
                <p class="text-xs text-ink-muted">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Quick Actions --}}
    <div>
        <h3 class="text-sm font-semibold text-ink-secondary uppercase tracking-wider mb-3">Aksi Cepat</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('pengelola.events.create') }}" class="flex items-center gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border hover:border-coral/40 transition-colors group">
                <div class="w-10 h-10 rounded-lg bg-coral/10 flex items-center justify-center shrink-0 group-hover:bg-coral/20 transition-colors">
                    <svg class="w-5 h-5 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-ink-primary">Buat Event Baru</p>
                    <p class="text-xs text-ink-muted">Tambah event baru</p>
                </div>
            </a>
            <a href="{{ route('pengelola.categories.create') }}" class="flex items-center gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border hover:border-coral/40 transition-colors group">
                <div class="w-10 h-10 rounded-lg bg-coral/10 flex items-center justify-center shrink-0 group-hover:bg-coral/20 transition-colors">
                    <svg class="w-5 h-5 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-ink-primary">Buat Kategori</p>
                    <p class="text-xs text-ink-muted">Tambah kategori baru</p>
                </div>
            </a>
        </div>
    </div>

    {{-- Recent Events --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-ink-secondary uppercase tracking-wider">Event Terbaru</h3>
            <a href="{{ route('pengelola.events.index') }}" class="text-xs text-coral hover:underline">Lihat semua</a>
        </div>

        @if(isset($recentEvents) && $recentEvents->count())
            <div class="space-y-3">
                @foreach($recentEvents as $event)
                    @php
                        $statusMap = [
                            'upcoming'  => ['label' => 'Akan Datang', 'bg' => 'bg-blue-500/10',    'text' => 'text-blue-300'],
                            'ongoing'   => ['label' => 'Berlangsung', 'bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-300'],
                            'completed' => ['label' => 'Selesai',     'bg' => 'bg-ink-muted/20',   'text' => 'text-ink-muted'],
                            'canceled'  => ['label' => 'Dibatalkan',  'bg' => 'bg-red-500/10',     'text' => 'text-red-300'],
                        ];
                        $st = $statusMap[$event->status] ?? $statusMap['upcoming'];
                    @endphp
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-navy-surface border border-navy-border">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('pengelola.events.show', $event) }}" class="text-sm font-medium text-ink-primary hover:text-coral truncate block">{{ $event->title }}</a>
                            <p class="text-xs text-ink-muted mt-0.5">{{ $event->start_date->isoFormat('D MMM YYYY') }} • {{ $event->registrations_count ?? 0 }}/{{ $event->capacity }} peserta</p>
                        </div>
                        <span class="shrink-0 text-xs px-2.5 py-1 rounded-full {{ $st['bg'] }} {{ $st['text'] }}">{{ $st['label'] }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 rounded-xl bg-navy-surface border border-navy-border border-dashed">
                <svg class="w-8 h-8 text-ink-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm text-ink-muted mb-3">Belum ada event</p>
                <a href="{{ route('pengelola.events.create') }}" class="text-sm text-coral hover:underline">Buat event sekarang</a>
            </div>
        @endif
    </div>
</div>

</x-layouts.dashboard>
