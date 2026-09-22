@php
    $statusColors = [
        'upcoming'  => ['bg' => 'bg-blue-500/15', 'text' => 'text-blue-300', 'dot' => 'bg-blue-400'],
        'ongoing'   => ['bg' => 'bg-emerald-500/15', 'text' => 'text-emerald-300', 'dot' => 'bg-emerald-400'],
        'completed' => ['bg' => 'bg-ink-muted/20', 'text' => 'text-ink-muted', 'dot' => 'bg-ink-muted'],
        'canceled'  => ['bg' => 'bg-red-500/15', 'text' => 'text-red-300', 'dot' => 'bg-red-400'],
    ];
    $sc = $statusColors[$event->status] ?? $statusColors['upcoming'];

    $statusLabels = [
        'upcoming'  => 'Akan Datang',
        'ongoing'   => 'Sedang Berlangsung',
        'completed' => 'Selesai',
        'canceled'  => 'Dibatalkan',
    ];

    $filledSlots   = $event->registrations_count ?? $event->registrations->whereIn('status', ['pending', 'approved'])->count();
    $remaining     = $event->capacity - $filledSlots;
    $fillPercent   = $event->capacity > 0 ? min(100, round($filledSlots / $event->capacity * 100)) : 0;
    $canRegister   = auth()->check() && auth()->user()->role === 'peserta'
                     && $event->status === 'upcoming'
                     && $remaining > 0;
    $alreadyJoined = auth()->check() && isset($registered) && $registered;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->title }} — STS Event</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-navy-main text-ink-primary font-sans antialiased" x-data="{ modalOpen: false }">

{{-- Nav --}}
<nav class="sticky top-0 z-40 bg-navy-main/90 backdrop-blur border-b border-navy-border">
    <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 text-ink-secondary hover:text-ink-primary transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
        <div class="flex items-center gap-3">
            @auth
                @if(auth()->user()->role === 'peserta')
                    <a href="{{ route('peserta.dashboard') }}" class="text-sm text-ink-secondary hover:text-ink-primary transition-colors">Dashboard</a>
                @elseif(auth()->user()->role === 'pengelola')
                    <a href="{{ route('pengelola.dashboard') }}" class="text-sm text-ink-secondary hover:text-ink-primary transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-ink-secondary hover:text-ink-primary transition-colors">Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-sm text-ink-secondary hover:text-ink-primary transition-colors">Masuk</a>
            @endauth
        </div>
    </div>
</nav>

<div class="max-w-5xl mx-auto px-4 py-10 lg:py-14">
    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 px-4 py-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 flex items-center gap-3 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="lg:grid lg:grid-cols-3 lg:gap-10">
        {{-- Left: Main Info --}}
        <div class="lg:col-span-2">
            {{-- Category & Status --}}
            <div class="flex flex-wrap items-center gap-2 mb-4">
                @if($event->category)
                    <span class="text-xs px-2.5 py-1 rounded-full bg-coral/10 text-coral border border-coral/20">
                        {{ $event->category->name }}
                    </span>
                @endif
                <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full {{ $sc['bg'] }} {{ $sc['text'] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                    {{ $statusLabels[$event->status] }}
                </span>
            </div>

            <h1 class="text-2xl lg:text-3xl font-bold text-ink-primary leading-tight mb-6">{{ $event->title }}</h1>

            {{-- Meta Grid --}}
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <div class="flex items-start gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border">
                    <div class="w-8 h-8 rounded-lg bg-coral/10 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <dt class="text-xs text-ink-muted mb-0.5">Mulai</dt>
                        <dd class="text-sm font-medium text-ink-primary">{{ $event->start_date->isoFormat('D MMMM YYYY, HH:mm') }}</dd>
                    </div>
                </div>
                @if($event->end_date)
                <div class="flex items-start gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border">
                    <div class="w-8 h-8 rounded-lg bg-coral/10 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <dt class="text-xs text-ink-muted mb-0.5">Selesai</dt>
                        <dd class="text-sm font-medium text-ink-primary">{{ $event->end_date->isoFormat('D MMMM YYYY, HH:mm') }}</dd>
                    </div>
                </div>
                @endif
                <div class="flex items-start gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border">
                    <div class="w-8 h-8 rounded-lg bg-coral/10 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <dt class="text-xs text-ink-muted mb-0.5">Lokasi</dt>
                        <dd class="text-sm font-medium text-ink-primary">{{ $event->location }}</dd>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border">
                    <div class="w-8 h-8 rounded-lg bg-coral/10 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <dt class="text-xs text-ink-muted mb-0.5">Kapasitas</dt>
                        <dd class="text-sm font-medium text-ink-primary">{{ $filledSlots }} / {{ $event->capacity }} peserta</dd>
                    </div>
                </div>
            </dl>

            {{-- Description --}}
            <h2 class="text-sm font-semibold text-ink-secondary uppercase tracking-wider mb-3">Deskripsi</h2>
            <div class="prose prose-sm max-w-none text-ink-secondary leading-relaxed">
                {!! nl2br(e($event->description)) !!}
            </div>

            {{-- Organizer --}}
            @if($event->pengelola)
                <div class="mt-8 flex items-center gap-3 p-4 rounded-xl bg-navy-surface border border-navy-border">
                    <div class="w-9 h-9 rounded-full bg-coral/20 flex items-center justify-center shrink-0">
                        <span class="text-coral text-sm font-semibold">{{ strtoupper(substr($event->pengelola->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-ink-muted">Penyelenggara</p>
                        <p class="text-sm font-medium text-ink-primary">{{ $event->pengelola->name }}</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Right: Registration Card --}}
        <div class="mt-8 lg:mt-0">
            <div class="sticky top-24 p-6 rounded-2xl bg-navy-surface border border-navy-border">
                <h3 class="font-semibold text-ink-primary mb-4">Pendaftaran</h3>

                {{-- Capacity Bar --}}
                <div class="mb-5">
                    <div class="flex justify-between text-xs text-ink-muted mb-2">
                        <span>{{ $filledSlots }} terdaftar</span>
                        <span>{{ $remaining }} sisa</span>
                    </div>
                    <div class="h-1.5 bg-navy-border rounded-full overflow-hidden">
                        <div class="h-full bg-coral rounded-full transition-all duration-500" style="width: {{ $fillPercent }}%"></div>
                    </div>
                </div>

                @if($alreadyJoined)
                    <div class="flex items-center gap-2 justify-center px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Sudah terdaftar
                    </div>
                    <p class="text-center text-xs text-ink-muted mt-3">
                        Lihat status di <a href="{{ route('peserta.registrations.index') }}" class="text-coral hover:underline">pendaftaran saya</a>
                    </p>
                @elseif($canRegister)
                    <button @click="modalOpen = true"
                            class="w-full px-4 py-3 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">
                        Daftar Sekarang
                    </button>
                @elseif(!auth()->check())
                    <a href="{{ route('login') }}"
                       class="block w-full text-center px-4 py-3 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">
                        Masuk untuk Mendaftar
                    </a>
                    <p class="text-center text-xs text-ink-muted mt-3">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-coral hover:underline">Daftar</a>
                    </p>
                @elseif($remaining <= 0)
                    <div class="text-center px-4 py-3 rounded-xl bg-white/5 text-ink-muted text-sm">Kuota penuh</div>
                @elseif($event->status !== 'upcoming')
                    <div class="text-center px-4 py-3 rounded-xl bg-white/5 text-ink-muted text-sm">Pendaftaran ditutup</div>
                @else
                    <div class="text-center px-4 py-3 rounded-xl bg-white/5 text-ink-muted text-sm">Tidak tersedia</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Registration Confirmation Modal --}}
<div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     style="display:none">
    <div class="absolute inset-0 bg-black/60" @click="modalOpen = false"></div>
    <div class="relative w-full max-w-sm bg-navy-surface rounded-2xl border border-navy-border p-6 shadow-2xl"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="scale-100 opacity-100" x-transition:leave-end="scale-95 opacity-0">
        <h3 class="text-lg font-semibold text-ink-primary mb-2">Konfirmasi Pendaftaran</h3>
        <p class="text-sm text-ink-secondary mb-1">Kamu akan mendaftar untuk:</p>
        <p class="text-sm font-medium text-ink-primary mb-5">{{ $event->title }}</p>

        <form method="POST" action="{{ route('peserta.events.register', $event) }}">
            @csrf
            <div class="flex gap-3">
                <button type="button" @click="modalOpen = false"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-sm text-ink-secondary transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-coral hover:bg-coral-hover text-white text-sm font-semibold transition-colors">
                    Ya, Daftar
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
