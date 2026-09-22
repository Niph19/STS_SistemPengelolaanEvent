@props(['title' => ''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title . ' — STS Event' : config('app.name') . ' — STS Event' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;1,14..32,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#070D1A] text-[#F5F3EE] font-sans antialiased">

    <div class="min-h-screen flex">

        {{-- ==================== LEFT PANEL (branding) ==================== --}}
        <div class="hidden lg:flex lg:w-[52%] xl:w-[55%] relative overflow-hidden flex-col">
            {{-- Deep gradient background --}}
            <div class="absolute inset-0 bg-gradient-to-br from-[#0F1729] via-[#0c1630] to-[#070D1A]"></div>

            {{-- Decorative grid --}}
            <div class="absolute inset-0 opacity-[0.04]"
                 style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 40px 40px;"></div>

            {{-- Glow orbs --}}
            <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-[#E8734A]/10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] bg-[#3B5FCC]/10 rounded-full blur-[100px]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-[#E8734A]/[0.05] rounded-full blur-[80px]"></div>

            {{-- Content --}}
            <div class="relative z-10 flex flex-col h-full p-12 xl:p-16">

                {{-- Logo --}}
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group w-fit">
                    <div class="w-10 h-10 rounded-xl bg-[#E8734A]/10 border border-[#E8734A]/20 flex items-center justify-center text-[#E8734A] group-hover:bg-[#E8734A]/20 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-lg font-bold tracking-tight text-[#F5F3EE] leading-none">
                            Event<span class="text-[#E8734A]">Sekolah</span>
                        </div>
                    </div>
                </a>

                {{-- Main hero text --}}
                <div class="flex-1 flex flex-col justify-center mt-auto mb-auto py-16">
                    <div class="max-w-md">

                        <h1 class="text-4xl xl:text-5xl font-bold text-[#F5F3EE] leading-[1.15] tracking-tight mb-6">
                            Kelola & Ikuti<br>
                            Event Sekolah<br>
                            <span class="text-[#E8734A]">dengan Mudah</span>
                        </h1>

                        <p class="text-[#9BA3B8] text-base leading-relaxed mb-10">
                            Satu tempat untuk menemukan dan mendaftar semua event sekolah. Kuota real-time, konfirmasi instan, status pendaftaran selalu dalam genggaman.                        </p>

                        <div class="flex items-center gap-8 pt-8 border-t border-white/[0.06]">
                    @foreach([
                        ['label' => 'Event Aktif', 'value' => '12+'],
                        ['label' => 'Peserta Terdaftar', 'value' => '250+'],
                        ['label' => 'Kategori', 'value' => '5'],
                    ] as $stat)
                        <div>
                            <div class="text-xl font-bold text-[#F5F3EE]">{{ $stat['value'] }}</div>
                            <div class="text-xs text-[#9BA3B8]">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== RIGHT PANEL (form) ==================== --}}
        <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 lg:px-12 bg-[#0A1120] relative">

            {{-- Subtle top border accent --}}
            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#E8734A]/20 to-transparent"></div>

            {{-- Mobile logo --}}
            <div class="lg:hidden mb-10">
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-[10px] bg-[#E8734A]/10 border border-[#E8734A]/20 flex items-center justify-center text-[#E8734A]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="text-lg font-bold text-[#F5F3EE]">
                        Event<span class="text-[#E8734A]">Sekolah</span>
                    </div>
                </a>
            </div>

            {{-- Form card --}}
            <div class="w-full max-w-[420px]">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <p class="mt-10 text-xs text-[#4A556B]">
                © {{ date('Y') }} EventSekolah. Semua hak dilindungi.
            </p>

        </div>

    </div>

</body>
</html>
