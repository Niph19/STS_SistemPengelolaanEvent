<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }} — STS Event</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-navy-main text-ink-primary font-sans antialiased lg:flex" x-data="{ sidebarOpen: false }">

{{-- Mobile Sidebar Overlay --}}
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-200"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-200"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-40 bg-black/60 lg:hidden"
     @click="sidebarOpen = false" style="display:none"></div>

{{-- Sidebar --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-navy-surface border-r border-navy-border flex flex-col transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:z-auto">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 h-16 border-b border-navy-border shrink-0">
        <div class="w-8 h-8 rounded-lg bg-coral flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <span class="font-semibold text-ink-primary tracking-tight">STS Event</span>
    </div>

    {{-- Role Badge --}}
    <div class="px-6 py-4 border-b border-navy-border shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-coral/20 flex items-center justify-center shrink-0">
                <span class="text-coral text-sm font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-ink-primary truncate">{{ auth()->user()->name }}</p>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium
                    @if(auth()->user()->role === 'admin') bg-purple-500/15 text-purple-300
                    @elseif(auth()->user()->role === 'pengelola') bg-blue-500/15 text-blue-300
                    @else bg-coral/15 text-coral @endif">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
        @if(auth()->user()->role === 'admin')
            <x-sidebar-link route="admin.dashboard" label="Dashboard" icon="home"/>
            <x-sidebar-link route="admin.users.index" label="Kelola User" icon="users"/>
            <x-sidebar-link route="admin.categories.index" label="Kategori" icon="tag"/>
        @elseif(auth()->user()->role === 'pengelola')
            <x-sidebar-link route="pengelola.dashboard" label="Dashboard" icon="home"/>
            <x-sidebar-link route="pengelola.events.index" label="Event" icon="calendar"/>
            <x-sidebar-link route="pengelola.categories.index" label="Kategori" icon="tag"/>
        @else
            <x-sidebar-link route="peserta.dashboard" label="Dashboard" icon="home"/>
            <x-sidebar-link route="peserta.registrations.index" label="Pendaftaran Saya" icon="clipboard"/>
        @endif

        <div class="pt-4 mt-4 border-t border-navy-border">
            <x-sidebar-link route="profile.edit" label="Profil" icon="user"/>
            <x-sidebar-link route="landing" label="Lihat Website" icon="globe"/>
        </div>
    </nav>

    {{-- Logout --}}
    <div class="px-3 pb-4 shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-ink-secondary hover:text-ink-primary hover:bg-white/5 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Main Content --}}
<div class="flex-1 flex flex-col min-w-0" style="min-height: 100vh;">
    {{-- Top Bar --}}
    <header class="h-16 bg-navy-surface border-b border-navy-border flex items-center justify-between px-4 lg:px-6 sticky top-0 z-30 shrink-0">
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-ink-secondary hover:text-ink-primary hover:bg-white/5 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <h1 class="text-base font-semibold text-ink-primary">{{ $title ?? 'Dashboard' }}</h1>
        <div class="flex items-center gap-2">
            <span class="hidden sm:block text-xs text-ink-muted">{{ now()->isoFormat('D MMM YYYY') }}</span>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="mx-4 lg:mx-6 mt-4 flex items-center gap-3 px-4 py-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="mx-4 lg:mx-6 mt-4 flex items-center gap-3 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Page Content --}}
    <main class="flex-1 p-4 lg:p-6">
        {{ $slot }}
    </main>
</div>

</body>
</html>
