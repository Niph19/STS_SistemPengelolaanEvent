<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }} — STS Event</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0F1729] text-[#F5F3EE] font-sans antialiased flex flex-col items-center justify-center px-4 py-12">

    {{-- Background ambient glow --}}
    <div class="fixed top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[300px] bg-[#E8734A]/[0.05] rounded-full blur-[120px] pointer-events-none"></div>

    {{-- Brand --}}
    <a href="{{ route('landing') }}" class="flex items-center gap-3 mb-8 group">
        <div class="w-9 h-9 rounded-[8px] bg-[#1A2540] border border-white/[0.08] flex items-center justify-center text-[#E8734A] group-hover:border-[#E8734A]/40 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div class="flex flex-col">
            <span class="text-lg font-bold tracking-tight text-[#F5F3EE]">
                Event<span class="text-[#E8734A]">Sekolah</span>
            </span>
            <span class="text-[10px] text-[#9BA3B8] font-medium tracking-wider -mt-0.5">Portal Pendaftaran</span>
        </div>
    </a>

    {{-- Card --}}
    <div class="w-full max-w-md bg-[#1A2540] border border-white/[0.08] rounded-2xl shadow-2xl p-8 relative z-10">
        {{ $slot }}
    </div>

</body>
</html>
