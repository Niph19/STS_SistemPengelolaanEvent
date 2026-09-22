<x-layouts.dashboard :title="'Pendaftaran Saya'">

<div class="space-y-5">
    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('peserta.registrations.index') }}" class="flex flex-col sm:flex-row gap-3">
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
            <option value="pending"  @selected(request('status') === 'pending')>Menunggu</option>
            <option value="approved" @selected(request('status') === 'approved')>Diterima</option>
            <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
            <option value="canceled" @selected(request('status') === 'canceled')>Dibatalkan</option>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">Cari</button>
    </form>

    {{-- Table --}}
    @if(isset($registrations) && $registrations->count())
        {{-- Mobile Cards --}}
        <div class="space-y-3 lg:hidden">
            @foreach($registrations as $reg)
                @php
                    $statusMap = [
                        'pending'  => ['label' => 'Menunggu',  'bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-400'],
                        'approved' => ['label' => 'Diterima',  'bg' => 'bg-emerald-500/10','text' => 'text-emerald-400'],
                        'rejected' => ['label' => 'Ditolak',   'bg' => 'bg-red-500/10',    'text' => 'text-red-400'],
                        'canceled' => ['label' => 'Dibatalkan','bg' => 'bg-white/5',        'text' => 'text-ink-muted'],
                    ];
                    $rs = $statusMap[$reg->status] ?? $statusMap['pending'];
                @endphp
                <div class="p-4 rounded-xl bg-navy-surface border border-navy-border">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-ink-primary truncate">{{ $reg->event->title }}</p>
                            <p class="text-xs text-ink-muted mt-0.5">{{ $reg->registered_at->isoFormat('D MMM YYYY, HH:mm') }}</p>
                        </div>
                        <span class="shrink-0 text-xs px-2.5 py-1 rounded-full {{ $rs['bg'] }} {{ $rs['text'] }}">{{ $rs['label'] }}</span>
                    </div>
                    @if($reg->status === 'pending')
                        <form method="POST" action="{{ route('peserta.registrations.destroy', $reg) }}" onsubmit="return confirm('Batalkan pendaftaran?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:underline">Batalkan</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Desktop Table --}}
        <div class="hidden lg:block overflow-x-auto rounded-xl border border-navy-border">
            <table class="w-full text-sm text-left">
                <thead class="bg-navy-surface text-xs text-ink-muted uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Event</th>
                        <th class="px-5 py-3">Tanggal Event</th>
                        <th class="px-5 py-3">Tanggal Daftar</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-border">
                    @foreach($registrations as $reg)
                        @php
                            $statusMap = [
                                'pending'  => ['label' => 'Menunggu',  'bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-400'],
                                'approved' => ['label' => 'Diterima',  'bg' => 'bg-emerald-500/10','text' => 'text-emerald-400'],
                                'rejected' => ['label' => 'Ditolak',   'bg' => 'bg-red-500/10',    'text' => 'text-red-400'],
                                'canceled' => ['label' => 'Dibatalkan','bg' => 'bg-white/5',        'text' => 'text-ink-muted'],
                            ];
                            $rs = $statusMap[$reg->status] ?? $statusMap['pending'];
                        @endphp
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-5 py-4">
                                <a href="{{ route('events.show', $reg->event) }}" class="font-medium text-ink-primary hover:text-coral transition-colors">{{ $reg->event->title }}</a>
                            </td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $reg->event->start_date->isoFormat('D MMM YYYY') }}</td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $reg->registered_at->isoFormat('D MMM YYYY, HH:mm') }}</td>
                            <td class="px-5 py-4">
                                <span class="text-xs px-2.5 py-1 rounded-full {{ $rs['bg'] }} {{ $rs['text'] }}">{{ $rs['label'] }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                @if($reg->status === 'pending')
                                    <form method="POST" action="{{ route('peserta.registrations.destroy', $reg) }}" class="inline" onsubmit="return confirm('Batalkan pendaftaran?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-red-400 hover:underline">Batalkan</button>
                                    </form>
                                @else
                                    <span class="text-xs text-ink-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($registrations->hasPages())
            <div class="mt-4">
                {{ $registrations->links() }}
            </div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center py-16 rounded-xl bg-navy-surface border border-navy-border border-dashed">
            <svg class="w-10 h-10 text-ink-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-sm text-ink-muted mb-1">Pendaftaran tidak ditemukan</p>
            <a href="{{ route('landing') }}" class="text-sm text-coral hover:underline mt-2">Cari event</a>
        </div>
    @endif
</div>

</x-layouts.dashboard>
