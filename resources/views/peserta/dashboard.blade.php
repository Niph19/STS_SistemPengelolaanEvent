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
                ['label' => 'Total Pendaftaran', 'value' => $totalRegistrations ?? 0, 'color' => 'text-coral'],
                ['label' => 'Menunggu',          'value' => $pendingCount ?? 0,        'color' => 'text-yellow-400'],
                ['label' => 'Diterima',          'value' => $approvedCount ?? 0,       'color' => 'text-emerald-400'],
                ['label' => 'Ditolak',           'value' => $rejectedCount ?? 0,       'color' => 'text-red-400'],
            ];
        @endphp
        @foreach($stats as $s)
            <div class="p-4 rounded-xl bg-navy-surface border border-navy-border">
                <p class="text-xs text-ink-muted mb-2">{{ $s['label'] }}</p>
                <p class="text-2xl font-bold {{ $s['color'] }}">{{ $s['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Recent Registrations --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-ink-secondary uppercase tracking-wider">Pendaftaran Terbaru</h3>
            <a href="{{ route('peserta.registrations.index') }}" class="text-xs text-coral hover:underline">Lihat semua</a>
        </div>

        @if(isset($recentRegistrations) && $recentRegistrations->count())
            <div class="space-y-3">
                @foreach($recentRegistrations as $reg)
                    @php
                        $statusMap = [
                            'pending'  => ['label' => 'Menunggu',  'bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-400'],
                            'approved' => ['label' => 'Diterima',  'bg' => 'bg-emerald-500/10','text' => 'text-emerald-400'],
                            'rejected' => ['label' => 'Ditolak',   'bg' => 'bg-red-500/10',    'text' => 'text-red-400'],
                            'canceled' => ['label' => 'Dibatalkan','bg' => 'bg-white/5',        'text' => 'text-ink-muted'],
                        ];
                        $rs = $statusMap[$reg->status] ?? $statusMap['pending'];
                    @endphp
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-navy-surface border border-navy-border">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('events.show', $reg->event) }}" class="text-sm font-medium text-ink-primary hover:text-coral truncate block transition-colors">{{ $reg->event->title }}</a>
                            <p class="text-xs text-ink-muted mt-0.5">{{ $reg->event->start_date->isoFormat('D MMM YYYY') }}</p>
                        </div>
                        <span class="shrink-0 text-xs px-2.5 py-1 rounded-full {{ $rs['bg'] }} {{ $rs['text'] }}">
                            {{ $rs['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 rounded-xl bg-navy-surface border border-navy-border border-dashed">
                <svg class="w-8 h-8 text-ink-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-sm text-ink-muted mb-3">Belum ada pendaftaran</p>
                <a href="{{ route('landing') }}" class="text-sm text-coral hover:underline">Cari event sekarang</a>
            </div>
        @endif
    </div>
</div>

</x-layouts.dashboard>
