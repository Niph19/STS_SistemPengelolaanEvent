<x-layouts.guest :title="'Masuk'">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#F5F3EE] tracking-tight mb-2">Selamat datang kembali</h1>
        <p class="text-sm text-[#6B7A99]">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#E8734A] hover:text-[#F2A671] font-medium transition-colors">Daftar sekarang</a>
        </p>
    </div>

    {{-- Session Status --}}
    @if(session('status'))
        <div class="mb-5 flex items-start gap-3 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    {{-- Error message --}}
    @if(session('error'))
        <div class="mb-5 flex items-start gap-3 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div class="space-y-1.5">
            <label for="email" class="block text-sm font-medium text-[#C4CBDC]">
                Alamat Email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#4A556B]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       placeholder="nama@email.com"
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#3A4560] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0
                              {{ $errors->has('email') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-[#1E2E4A] hover:border-[#2A3E5A] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/15' }}">
            </div>
            @error('email')
                <p class="flex items-center gap-1.5 text-xs text-red-400 mt-1">
                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <label for="password" class="text-sm font-medium text-[#C4CBDC]">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs text-[#6B7A99] hover:text-[#E8734A] transition-colors">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#4A556B]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-11 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#3A4560] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0
                              {{ $errors->has('password') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-[#1E2E4A] hover:border-[#2A3E5A] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/15' }}">
                {{-- Toggle password visibility --}}
                <button type="button" onclick="togglePassword('password', this)"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-[#4A556B] hover:text-[#9BA3B8] transition-colors">
                    <svg class="w-4 h-4 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg class="w-4 h-4 eye-closed hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="flex items-center gap-1.5 text-xs text-red-400 mt-1">
                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded-md border-[#1E2E4A] bg-[#0F1729] text-[#E8734A] focus:ring-[#E8734A]/30 focus:ring-offset-[#0A1120]">
            <label for="remember_me" class="text-sm text-[#6B7A99] cursor-pointer select-none">Ingat saya selama 30 hari</label>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="relative w-full py-3 px-4 bg-[#E8734A] hover:bg-[#D4623C] active:bg-[#C05530] text-white font-semibold text-sm rounded-xl transition-all duration-200 shadow-lg shadow-[#E8734A]/20 hover:shadow-[#E8734A]/30 focus:outline-none focus:ring-2 focus:ring-[#E8734A]/50 focus:ring-offset-2 focus:ring-offset-[#0A1120] overflow-hidden group">
            <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk ke Akun
            </span>
        </button>

        {{-- Demo credentials info --}}
        <div class="mt-4 p-3.5 rounded-xl bg-[#0F1729] border border-[#1E2E4A]">
            <p class="text-xs font-semibold text-[#6B7A99] mb-2 uppercase tracking-wider">Akun Demo</p>
            <div class="space-y-1.5 text-xs text-[#9BA3B8]">
                <div class="flex items-center gap-2">
                    <span class="w-16 text-[#6B7A99]">Admin</span>
                    <span class="font-mono text-[#C4CBDC]">admin@sts.id</span>
                    <span class="text-[#4A556B]">•</span>
                    <span class="font-mono">password</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-16 text-[#6B7A99]">Pengelola</span>
                    <span class="font-mono text-[#C4CBDC]">pengelola@sts.id</span>
                    <span class="text-[#4A556B]">•</span>
                    <span class="font-mono">password</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-16 text-[#6B7A99]">Peserta</span>
                    <span class="font-mono text-[#C4CBDC]">peserta@sts.id</span>
                    <span class="text-[#4A556B]">•</span>
                    <span class="font-mono">password</span>
                </div>
            </div>
        </div>
    </form>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>

</x-layouts.guest>
