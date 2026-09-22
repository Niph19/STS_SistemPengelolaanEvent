<x-layouts.guest :title="'Masuk'">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#F5F3EE] tracking-tight mb-1">Masuk ke akun</h1>
        <p class="text-sm text-[#9BA3B8]">Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#E8734A] hover:text-[#F2A671] font-medium transition-colors">Daftar sekarang</a>
        </p>
    </div>

    {{-- Session Status --}}
    @if(session('status'))
        <div class="mb-5 flex items-center gap-2 px-4 py-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-[#F5F3EE] mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#64748B] transition-colors focus:outline-none focus:ring-1
                          {{ $errors->has('email') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-white/[0.08] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20' }}"
                   placeholder="nama@email.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="text-sm font-medium text-[#F5F3EE]">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-[#9BA3B8] hover:text-[#E8734A] transition-colors">Lupa password?</a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#64748B] transition-colors focus:outline-none focus:ring-1
                          {{ $errors->has('password') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-white/[0.08] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20' }}"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-white/[0.08] bg-[#0F1729] text-[#E8734A] focus:ring-[#E8734A]/30 focus:ring-offset-[#1A2540]">
            <label for="remember_me" class="text-sm text-[#9BA3B8]">Ingat saya</label>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full py-2.5 px-4 bg-[#E8734A] hover:bg-[#F2A671] text-white font-semibold text-sm rounded-xl transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-[#E8734A]/50 focus:ring-offset-2 focus:ring-offset-[#1A2540]">
            Masuk
        </button>
    </form>

</x-layouts.guest>
