<x-layouts.dashboard :title="'Dashboard'">

<div class="space-y-6">
    {{-- Welcome --}}
    <div class="p-5 rounded-2xl bg-navy-surface border border-navy-border">
        <p class="text-xs text-ink-muted mb-1">Selamat datang,</p>
        <h2 class="text-lg font-semibold text-ink-primary">{{ auth()->user()->name }}</h2>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $stats = [
                ['label' => 'Total User',       'value' => $totalUsers ?? 0,         'color' => 'text-coral',       'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['label' => 'Pengelola',        'value' => $totalPengelola ?? 0,     'color' => 'text-blue-400',    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['label' => 'Peserta',          'value' => $totalPeserta ?? 0,       'color' => 'text-purple-400',  'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['label' => 'Total Kategori',   'value' => $totalCategories ?? 0,    'color' => 'text-emerald-400', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
            ];
        @endphp
        @foreach($stats as $s)
            <div class="p-4 rounded-xl bg-navy-surface border border-navy-border">
                <div class="mb-2">
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
            <a href="{{ route('admin.users.create') }}" class="flex items-center gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border hover:border-coral/40 transition-colors group">
                <div class="w-10 h-10 rounded-lg bg-coral/10 flex items-center justify-center shrink-0 group-hover:bg-coral/20 transition-colors">
                    <svg class="w-5 h-5 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-ink-primary">Tambah User</p>
                    <p class="text-xs text-ink-muted">Buat akun pengelola atau peserta</p>
                </div>
            </a>
            <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border hover:border-coral/40 transition-colors group">
                <div class="w-10 h-10 rounded-lg bg-coral/10 flex items-center justify-center shrink-0 group-hover:bg-coral/20 transition-colors">
                    <svg class="w-5 h-5 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-ink-primary">Tambah Kategori</p>
                    <p class="text-xs text-ink-muted">Buat kategori event baru</p>
                </div>
            </a>
        </div>
    </div>

    {{-- Recent Users --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-ink-secondary uppercase tracking-wider">User Terbaru</h3>
            <a href="{{ route('admin.users.index') }}" class="text-xs text-coral hover:underline">Lihat semua</a>
        </div>

        @if(isset($recentUsers) && $recentUsers->count())
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border">
                        <div class="w-9 h-9 rounded-full bg-coral/20 flex items-center justify-center shrink-0">
                            <span class="text-coral text-sm font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-ink-primary truncate">{{ $user->name }}</p>
                            <p class="text-xs text-ink-muted">{{ $user->email }}</p>
                        </div>
                        <span class="shrink-0 text-xs px-2.5 py-1 rounded-full
                            @if($user->role === 'admin') bg-purple-500/15 text-purple-300
                            @elseif($user->role === 'pengelola') bg-blue-500/15 text-blue-300
                            @else bg-coral/15 text-coral @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-10 text-center rounded-xl bg-navy-surface border border-navy-border border-dashed">
                <p class="text-sm text-ink-muted">Belum ada user terdaftar</p>
            </div>
        @endif
    </div>
</div>

</x-layouts.dashboard>
