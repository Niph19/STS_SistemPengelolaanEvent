<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EventSekolah — Pendaftaran Event</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0F1729] text-[#F5F3EE] font-sans antialiased selection:bg-[#E8734A] selection:text-white min-h-screen flex flex-col"
      x-data="{
          scrolled: false,
          activeCategory: 'all',
          searchQuery: ''
      }"
      @scroll.window="scrolled = (window.pageYOffset > 24)">

    <!-- Navbar -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            :class="scrolled ? 'bg-[#0F1729]/95 backdrop-blur-md border-b border-white/[0.08] shadow-2xl py-3' : 'bg-transparent border-b border-transparent py-5'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Brand / Logo -->
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-[8px] bg-[#1A2540] border border-white/[0.08] flex items-center justify-center text-[#E8734A] group-hover:border-[#E8734A]/40 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold tracking-tight text-[#F5F3EE] flex items-center gap-1">
                            Event<span class="text-[#E8734A]">Sekolah</span>
                        </span>
                        <span class="text-[10px] text-[#9BA3B8] font-medium tracking-wider uppercase -mt-1">Portal Pendaftaran</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-[#9BA3B8]">
                    <a href="#beranda" class="text-[#F5F3EE] hover:text-[#E8734A] transition-colors">Beranda</a>
                    <a href="#rekomendasi" class="hover:text-[#F5F3EE] transition-colors">Events</a>
                    <a href="#alur" class="hover:text-[#F5F3EE] transition-colors">Alur Daftar</a>
                </nav>

                <!-- Auth Action Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        @php
                            $dashboardRoute = match(Auth::user()->role) {
                                'admin' => route('admin.dashboard'),
                                'pengelola' => route('pengelola.dashboard'),
                                default => route('peserta.dashboard'),
                            };
                            $roleBadge = match(Auth::user()->role) {
                                'admin' => 'Admin',
                                'pengelola' => 'Pengelola',
                                default => 'Peserta',
                            };
                        @endphp
                        <a href="{{ $dashboardRoute }}"
                           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-[#F5F3EE] bg-[#1A2540] hover:bg-[#1A2540]/80 border border-white/[0.08] hover:border-[#E8734A]/40 rounded-[8px] transition-all">
                            <span class="w-2 h-2 rounded-full bg-[#E8734A]"></span>
                            <span>Dashboard ({{ $roleBadge }})</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 text-sm font-medium text-[#F5F3EE] hover:text-white bg-transparent hover:bg-[#1A2540] border border-white/[0.08] rounded-[8px] transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 text-sm font-semibold text-white bg-[#E8734A] hover:bg-[#F2A671] rounded-[8px] shadow-sm transition-all duration-200">
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section id="beranda" class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden">
            <!-- Subtle glow / ambient background element -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-[#E8734A]/5 rounded-full blur-[140px] pointer-events-none -z-10"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">

                    <!-- Left Column: Headline (Left-aligned as instructed) -->
                    <div class="lg:col-span-7 flex flex-col items-start text-left">

                        <!-- Main Headline -->
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-[#F5F3EE] leading-[1.18] mb-6">
                            Satu event sekolah, <br class="hidden sm:inline" />
                            <span class="text-[#E8734A]">satu tempat</span> untuk daftar.
                        </h1>

                        <!-- Subheadline -->
                        <p class="text-base sm:text-lg text-[#9BA3B8] leading-relaxed max-w-2xl mb-8 font-normal">
                            Temukan event terbaik di sekolah-sekolah, seminar, workshop kejuruan, lomba prestasi, hingga kegiatan OSIS. Amankan slotmu sebelum kuota penuh dan pantau status pendaftaran langsung dari dashboard-mu.
                        </p>

                        <!-- Quick Search & Action Bar -->
                        <form method="GET" action="{{ route('landing') }}" class="w-full max-w-xl bg-[#1A2540] p-2 rounded-[8px] border border-white/[0.08] shadow-xl flex flex-col sm:flex-row gap-2 mb-8">
                            <div class="relative flex-grow flex items-center">
                                <svg class="w-5 h-5 text-[#9BA3B8] absolute left-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Cari seminar, lomba, atau workshop..."
                                       class="w-full pl-10 pr-4 py-2.5 bg-transparent border-none text-sm text-[#F5F3EE] placeholder-[#9BA3B8]/60 focus:ring-0 focus:outline-none">
                            </div>
                            <button type="submit"
                               class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-[#E8734A] hover:bg-[#F2A671] rounded-[8px] transition-all whitespace-nowrap">
                                <span>Cari Event</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </form>

                        <!-- Stats Metric -->
                        <div class="grid grid-cols-3 gap-6 pt-4 border-t border-white/[0.08] w-full max-w-lg">
                            <div>
                                <div class="text-2xl font-bold text-[#F5F3EE]">{{ $activeEvents }}</div>
                                <div class="text-xs text-[#9BA3B8] mt-0.5">Event Aktif</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-[#E8734A]">{{ $registeredParticipants }}</div>
                                <div class="text-xs text-[#9BA3B8] mt-0.5">Peserta Terdaftar</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-[#F5F3EE]">100%</div>
                                <div class="text-xs text-[#9BA3B8] mt-0.5">Terverifikasi</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Hero Stacked Depth Cards (Aura Concept: max 3 cards, rotated -3deg, +2deg, 0deg, staggered load) -->
                    <div class="lg:col-span-5 relative flex items-center justify-center min-h-[420px] select-none">

                        <!-- Stack 1 (Back Card: -3deg rotation) -->
                        <div class="absolute w-full max-w-[340px] sm:max-w-[370px] bg-[#1A2540]/80 rounded-[8px] border border-white/[0.08] p-5 shadow-2xl animate-card-stack-1 -translate-y-4 scale-95 opacity-60 backdrop-blur-sm pointer-events-none">
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-0.5 text-[11px] font-semibold tracking-wide uppercase bg-white/[0.06] text-[#9BA3B8] rounded-[6px] border border-white/[0.08]">
                                    Lomba Prestasi
                                </span>
                                <span class="text-xs text-[#9BA3B8]">18 Okt 2026</span>
                            </div>
                            <h4 class="text-base font-semibold text-[#F5F3EE] mb-2 line-clamp-1">UI/UX National School Competition</h4>
                            <div class="flex items-center gap-4 text-xs text-[#9BA3B8]">
                                <span>📍 Lab Desain Multimedia</span>
                                <span>👥 Kuota: 40 Tim</span>
                            </div>
                        </div>

                        <!-- Stack 2 (Middle Card: +2deg rotation) -->
                        <div class="absolute w-full max-w-[340px] sm:max-w-[370px] bg-[#1A2540]/90 rounded-[8px] border border-white/[0.08] p-5 shadow-2xl animate-card-stack-2 -translate-y-2 scale-[0.98] opacity-85 backdrop-blur-sm pointer-events-none">
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-0.5 text-[11px] font-semibold tracking-wide uppercase bg-white/[0.06] text-[#9BA3B8] rounded-[6px] border border-white/[0.08]">
                                    Workshop
                                </span>
                                <span class="text-xs text-[#9BA3B8]">04 Okt 2026</span>
                            </div>
                            <h4 class="text-base font-semibold text-[#F5F3EE] mb-2 line-clamp-1">Cyber Security & Ethical Hacking Basics</h4>
                            <div class="flex items-center justify-between text-xs text-[#9BA3B8]">
                                <span>📍 Hall TI Gedung B</span>
                                <span class="text-[#E8734A] font-semibold">Tersisa 8 Kuota</span>
                            </div>
                        </div>

                        <!-- Stack 3 (Front Card: 0deg rotation, clear highlight & coral accent) -->
                        <div class="relative w-full max-w-[340px] sm:max-w-[370px] bg-[#1A2540] rounded-[8px] border border-white/[0.12] hover:border-[#E8734A]/40 p-5 sm:p-6 shadow-2xl animate-card-stack-3 transition-all duration-300 group">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 text-xs font-semibold uppercase tracking-wider bg-[#E8734A]/10 text-[#E8734A] border border-[#E8734A]/20 rounded-[6px]">
                                        Seminar Unggulan
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        Buka
                                    </span>
                                </div>
                                <span class="text-xs font-medium text-[#9BA3B8] bg-white/[0.04] px-2.5 py-1 rounded-[6px]">
                                    28 Sep 2026
                                </span>
                            </div>

                            <!-- Poster / Graphic Mini Banner -->
                            <div class="w-full h-36 rounded-[6px] bg-gradient-to-tr from-[#0F1729] via-[#1A2540] to-[#E8734A]/20 border border-white/[0.08] p-4 flex flex-col justify-end mb-4 relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#E8734A]/10 rounded-full blur-xl"></div>
                                <div class="text-[11px] font-medium text-[#E8734A] tracking-wider uppercase mb-1">Teknologi & Masa Depan</div>
                                <div class="text-sm font-bold text-white leading-snug">Menembus Industri Teknologi Global di Era AI</div>
                            </div>

                            <!-- Event Info -->
                            <div class="space-y-2 mb-5">
                                <div class="flex items-center gap-2 text-xs text-[#9BA3B8]">
                                    <svg class="w-4 h-4 text-[#E8734A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Auditorium Utama & Online Zoom</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-[#9BA3B8]">
                                    <svg class="w-4 h-4 text-[#E8734A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Penyelenggara: Komunitas IT & OSIS</span>
                                </div>
                            </div>

                            <!-- Capacity Progress Bar -->
                            <div class="mb-5">
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="text-[#9BA3B8]">Kapasitas Terisi</span>
                                    <span class="font-semibold text-[#F5F3EE]">165 / 200 Peserta</span>
                                </div>
                                <div class="w-full h-1.5 bg-[#0F1729] rounded-full overflow-hidden">
                                    <div class="h-full bg-[#E8734A] rounded-full" style="width: 82.5%"></div>
                                </div>
                            </div>

                            <!-- Action -->
                            <div class="flex items-center justify-between pt-3 border-t border-white/[0.08]">
                                <div>
                                    <span class="text-[10px] text-[#9BA3B8] block">Biaya Registrasi</span>
                                    <span class="text-sm font-bold text-emerald-400">Gratis (Free)</span>
                                </div>
                                <a href="#rekomendasi"
                                   class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-[8px] bg-[#E8734A] hover:bg-[#F2A671] text-white text-xs font-semibold transition-all">
                                    <span>Daftar Sekarang</span>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Category Filter Section (Horizontal Chips) -->
        <section id="kategori" class="py-6 border-y border-white/[0.08] bg-[#1A2540]/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4 overflow-x-auto pb-2 sm:pb-0 scrollbar-none">
                    <span class="text-xs font-semibold uppercase tracking-wider text-[#9BA3B8] whitespace-nowrap hidden md:inline">
                        Kategori Event:
                    </span>

                    <div class="flex items-center gap-2.5 flex-nowrap">
                        <a href="{{ route('landing', request()->except('category_id', 'page')) }}"
                                class="px-4 py-2 rounded-[8px] text-xs transition-all whitespace-nowrap {{ request('category_id') ? 'bg-[#1A2540] hover:bg-white/[0.06] text-[#9BA3B8] hover:text-[#F5F3EE] border border-white/[0.08]' : 'bg-[#E8734A] text-white font-semibold' }}">
                            Semua Event
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('landing', array_merge(request()->except('page'), ['category_id' => $category->id])) }}"
                               class="px-4 py-2 rounded-[8px] text-xs transition-all whitespace-nowrap {{ request('category_id') == $category->id ? 'bg-[#E8734A] text-white font-semibold' : 'bg-[#1A2540] hover:bg-white/[0.06] text-[#9BA3B8] hover:text-[#F5F3EE] border border-white/[0.08]' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @if($events->hasPages())
                    <div class="pagination-theme mt-4">{{ $events->links() }}</div>
                @endif
            </div>
        </section>

        <!-- Rekomendasi Event Section (Artitax Card Grid Concept: 4 Columns, Dark Palette, Coral Badges) -->
        <section id="rekomendasi" class="py-5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#E8734A] tracking-wider uppercase mb-2">
                            <span>Pilihan Terbaik</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#F5F3EE] tracking-tight">
                            Rekomendasi Event Pilihan
                        </h2>
                        <p class="text-sm text-[#9BA3B8] mt-1">
                            Daftar event populer dengan kuota terbatas yang paling banyak diminati siswa.
                        </p>
                    </div>

                    <!-- Search & Filter Controls -->
                    <form method="GET" action="{{ route('landing') }}" class="flex items-center gap-3">
                        @if(request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Filter nama event..."
                                   class="bg-[#1A2540] border border-white/[0.08] text-xs text-[#F5F3EE] placeholder-[#9BA3B8]/60 rounded-[8px] px-3.5 py-2 pl-9 focus:outline-none focus:border-[#E8734A]/40 transition-colors w-48 sm:w-60">
                            <svg class="w-4 h-4 text-[#9BA3B8] absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#E8734A] hover:bg-[#F2A671] rounded-[8px] transition-colors">
                            Cari
                        </button>
                    </form>
                </div>

                <!-- Event Cards 4-Column Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($events as $event)
                    <div
                         class="bg-[#1A2540] rounded-[8px] border border-white/[0.08] hover:border-[#E8734A]/40 transition-all duration-300 hover:-translate-y-1 flex flex-col overflow-hidden group">
                        <!-- Poster Image Container -->
                        <div class="relative h-44 bg-gradient-to-br from-[#0F1729] via-[#1A2540] to-blue-900/30 overflow-hidden border-b border-white/[0.08]">
                            <div class="absolute inset-0 flex items-center justify-center text-white/[0.07] group-hover:scale-105 transition-transform duration-500">
                                <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            </div>
                            <!-- Date Badge with Coral Accent -->
                            <div class="absolute top-3 left-3 bg-[#E8734A] text-white px-2.5 py-1 rounded-[6px] text-xs font-bold shadow-md">
                                {{ $event->start_date->format('d M') }}
                            </div>
                            <!-- Category Badge -->
                            <div class="absolute top-3 right-3 bg-[#0F1729]/80 backdrop-blur-md text-[#9BA3B8] border border-white/[0.08] px-2 py-0.5 rounded-[6px] text-[11px] font-medium">
                                {{ $event->category->name ?? 'Umum' }}
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 flex flex-col flex-grow justify-between">
                            <div>
                                <h3 class="text-base font-semibold text-[#F5F3EE] group-hover:text-[#E8734A] transition-colors line-clamp-2 leading-snug mb-2">
                                    {{ $event->title }}
                                </h3>

                                <p class="text-xs text-[#9BA3B8] line-clamp-2 mb-4 leading-relaxed">
                                    {{ $event->description }}
                                </p>

                                <div class="space-y-2 mb-4 text-xs text-[#9BA3B8]">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-[#E8734A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $event->start_date->format('H:i') }} WIB</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-[#E8734A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        <span class="truncate">{{ $event->location }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-[#E8734A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="truncate">Penyelenggara: {{ $event->pengelola->name ?? 'Panitia' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Card: Quota, Price & Button -->
                            <div class="pt-4 border-t border-white/[0.08]">
                                <div class="flex items-center justify-between text-xs mb-3">
                                    <span class="text-emerald-400 font-bold">Gratis</span>
                                    <span class="text-[#9BA3B8]">Kapasitas: <strong class="text-[#F5F3EE]">{{ $event->registrations_count }}/{{ $event->capacity }}</strong></span>
                                </div>
                                <a href="{{ route('events.show', $event) }}"
                                   class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 text-xs font-semibold text-[#F5F3EE] bg-[#0F1729] hover:bg-[#E8734A] hover:text-white border border-white/[0.08] hover:border-transparent rounded-[8px] transition-all">
                                    <span>Lihat Detail / Daftar</span>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- 3-Step Registration Flow Section -->
        <section id="alur" class="py-20 bg-[#1A2540]/20 border-t border-white/[0.08]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <span class="text-xs font-semibold uppercase tracking-wider text-[#E8734A] mb-2 block">
                        Alur Pendaftaran
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#F5F3EE] tracking-tight">
                        Cara Mudah Mengikuti Event
                    </h2>
                    <p class="text-sm text-[#9BA3B8] mt-2">
                        Hanya butuh 3 langkah sederhana untuk mengamankan tiket partisipasimu.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-[#1A2540] p-6 rounded-[8px] border border-white/[0.08] relative">
                        <div class="w-10 h-10 rounded-[8px] bg-[#E8734A]/10 border border-[#E8734A]/20 text-[#E8734A] font-bold text-sm flex items-center justify-center mb-4">
                            01
                        </div>
                        <h3 class="text-base font-semibold text-[#F5F3EE] mb-2">Pilih Event yang Diminati</h3>
                        <p class="text-xs text-[#9BA3B8] leading-relaxed">
                            Cari dan telusuri berbagai seminar, workshop, atau kompetisi sesuai minat dan jurusanmu.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-[#1A2540] p-6 rounded-[8px] border border-white/[0.08] relative">
                        <div class="w-10 h-10 rounded-[8px] bg-[#E8734A]/10 border border-[#E8734A]/20 text-[#E8734A] font-bold text-sm flex items-center justify-center mb-4">
                            02
                        </div>
                        <h3 class="text-base font-semibold text-[#F5F3EE] mb-2">Login & Klik Daftar</h3>
                        <p class="text-xs text-[#9BA3B8] leading-relaxed">
                            Masuk dengan akun peserta atau daftar akun baru dalam 1 menit, lalu konfirmasi formulir pendaftaran.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-[#1A2540] p-6 rounded-[8px] border border-white/[0.08] relative">
                        <div class="w-10 h-10 rounded-[8px] bg-[#E8734A]/10 border border-[#E8734A]/20 text-[#E8734A] font-bold text-sm flex items-center justify-center mb-4">
                            03
                        </div>
                        <h3 class="text-base font-semibold text-[#F5F3EE] mb-2">Pantau Status di Dashboard</h3>
                        <p class="text-xs text-[#9BA3B8] leading-relaxed">
                            Cek status persetujuan, simpan bukti pendaftaran, dan ikuti kegiatan sesuai jadwal yang ditentukan.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Minimalis -->
    <footer class="bg-[#0F1729] border-t border-white/[0.08] py-12 text-[#9BA3B8] text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Col 1: Brand Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 rounded-[6px] bg-[#1A2540] border border-white/[0.08] flex items-center justify-center text-[#E8734A]">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-base font-bold text-[#F5F3EE]">
                            Event<span class="text-[#E8734A]">Sekolah</span>
                        </span>
                    </div>
                    <p class="text-xs text-[#9BA3B8] max-w-sm leading-relaxed mb-4">
                        Sistem manajemen pendaftaran dan pengelolaan kegiatan event sekolah terpusat, transparan, dan akurat.
                    </p>
                </div>

                <!-- Col 2: Kategori Cepat -->
                <div>
                    <h4 class="text-xs font-semibold text-[#F5F3EE] uppercase tracking-wider mb-3">Kategori Event</h4>
                    <ul class="space-y-2">
                        <li><a href="#kategori" class="hover:text-[#E8734A] transition-colors">Seminar & Talkshow</a></li>
                        <li><a href="#kategori" class="hover:text-[#E8734A] transition-colors">Workshop Kejuruan</a></li>
                        <li><a href="#kategori" class="hover:text-[#E8734A] transition-colors">Lomba & Kompetisi</a></li>
                        <li><a href="#kategori" class="hover:text-[#E8734A] transition-colors">Kegiatan OSIS & Seni</a></li>
                    </ul>
                </div>

                <!-- Col 3: Kontak & Bantuan -->
                <div>
                    <h4 class="text-xs font-semibold text-[#F5F3EE] uppercase tracking-wider mb-3">Kontak Panitia</h4>
                    <ul class="space-y-2">
                        <li>Email: <span class="text-[#F5F3EE]">event@smksekolah.sch.id</span></li>
                        <li>WhatsApp: <span class="text-[#F5F3EE]">+62 812-3456-7890</span></li>
                        <li>Jam Layanan: 07.30 - 15.30 WIB</li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 border-t border-white/[0.08] flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px]">
                <div>
                    &copy; {{ date('Y') }} EventSekolah (Niph19). Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-[#F5F3EE] transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-[#F5F3EE] transition-colors">Syarat & Ketentuan</a>
                    <a href="{{ route('login') }}" class="hover:text-[#E8734A] transition-colors">Portal Pengelola</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
