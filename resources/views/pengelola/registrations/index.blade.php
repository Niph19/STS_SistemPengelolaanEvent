<x-layouts.dashboard :title="'Peserta Event'">

<div class="space-y-5">
    {{-- Event Info --}}
    <div class="p-4 rounded-xl bg-navy-surface border border-navy-border">
        <p class="text-xs text-ink-muted mb-0.5">Event</p>
        <h2 class="text-base font-semibold text-ink-primary">{{ $event->title }}</h2>
        <p class="text-xs text-ink-muted mt-1">{{ $event->start_date->isoFormat('D MMM YYYY') }} • {{ $event->registrations_count ?? $registrations->total() }} peserta terdaftar</p>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('pengelola.events.registrations', $event) }}" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ink-muted pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
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
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <div>
                            <p class="text-sm font-medium text-ink-primary">{{ $reg->user->name }}</p>
                            <p class="text-xs text-ink-muted">{{ $reg->user->email }}</p>
                        </div>
                        <span class="shrink-0 text-xs px-2.5 py-1 rounded-full {{ $rs['bg'] }} {{ $rs['text'] }}">{{ $rs['label'] }}</span>
                    </div>
                    @if($reg->status === 'pending')
                        <div class="flex gap-2 mt-3">
                            <form method="POST" action="{{ route('pengelola.registrations.update-status', $reg) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="text-xs px-3 py-1.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-lg hover:bg-emerald-500/20 transition-colors">Terima</button>
                            </form>
                            <form method="POST" action="{{ route('pengelola.registrations.update-status', $reg) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="text-xs px-3 py-1.5 bg-red-500/10 text-red-400 border border-red-500/20 rounded-lg hover:bg-red-500/20 transition-colors">Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Desktop Table --}}
        <div class="hidden lg:block overflow-x-auto rounded-xl border border-navy-border">
            <table class="w-full text-sm text-left">
                <thead class="bg-navy-surface text-xs text-ink-muted uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Email</th>
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
                            <td class="px-5 py-4 font-medium text-ink-primary">{{ $reg->user->name }}</td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $reg->user->email }}</td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $reg->registered_at->isoFormat('D MMM YYYY, HH:mm') }}</td>
                            <td class="px-5 py-4">
                                <span class="text-xs px-2.5 py-1 rounded-full {{ $rs['bg'] }} {{ $rs['text'] }}">{{ $rs['label'] }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                @if($reg->status === 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('pengelola.registrations.update-status', $reg) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="text-xs text-emerald-400 hover:underline">Terima</button>
                                        </form>
                                        <form method="POST" action="{{ route('pengelola.registrations.update-status', $reg) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="text-xs text-red-400 hover:underline">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-ink-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="mt-4">{{ $registrations->links() }}</div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center py-16 rounded-xl bg-navy-surface border border-navy-border border-dashed">
            <svg class="w-10 h-10 text-ink-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <p class="text-sm text-ink-muted">Belum ada peserta yang mendaftar</p>
        </div>
    @endif
</div>

</x-layouts.dashboard>
