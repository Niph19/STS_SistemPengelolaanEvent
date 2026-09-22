<x-layouts.guest :title="'Daftar Akun'">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#F5F3EE] tracking-tight mb-2">Buat akun baru</h1>
        <p class="text-sm text-[#6B7A99]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#E8734A] hover:text-[#F2A671] font-medium transition-colors">Masuk di sini</a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div class="space-y-1.5">
            <label for="name" class="block text-sm font-medium text-[#C4CBDC]">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#4A556B]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       required autofocus autocomplete="name"
                       placeholder="Ahmad Fauzi"
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#3A4560] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0
                              {{ $errors->has('name') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-[#1E2E4A] hover:border-[#2A3E5A] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/15' }}">
            </div>
            @error('name')
                <p class="flex items-center gap-1.5 text-xs text-red-400">
                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="space-y-1.5">
            <label for="email" class="block text-sm font-medium text-[#C4CBDC]">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#4A556B]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autocomplete="username"
                       placeholder="nama@email.com"
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#3A4560] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0
                              {{ $errors->has('email') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-[#1E2E4A] hover:border-[#2A3E5A] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/15' }}">
            </div>
            @error('email')
                <p class="flex items-center gap-1.5 text-xs text-red-400">
                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Role selection cards --}}
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#C4CBDC]">Daftar sebagai</label>
            <div class="grid grid-cols-2 gap-3">
                {{-- Peserta card --}}
                <label for="role_peserta" class="role-card cursor-pointer group">
                    <input type="radio" id="role_peserta" name="role" value="peserta"
                           {{ old('role', 'peserta') === 'peserta' ? 'checked' : '' }}
                           class="sr-only peer" onchange="updateRoleCards()">
                    <div class="p-4 rounded-xl border-2 transition-all duration-200 bg-[#0F1729]
                                peer-checked:border-[#E8734A] peer-checked:bg-[#E8734A]/5
                                border-[#1E2E4A] group-hover:border-[#2A3E5A]">
                        <div class="w-8 h-8 rounded-lg bg-[#1A2540] flex items-center justify-center mb-2.5 transition-colors peer-checked:bg-[#E8734A]/15">
                            <svg class="w-4 h-4 text-[#6B7A99] group-[.selected]:text-[#E8734A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="text-sm font-semibold text-[#C4CBDC] mb-0.5">Peserta</div>
                        <div class="text-xs text-[#6B7A99]">Ikuti event</div>
                    </div>
                </label>

                {{-- Pengelola card --}}
                <label for="role_pengelola" class="role-card cursor-pointer group">
                    <input type="radio" id="role_pengelola" name="role" value="pengelola"
                           {{ old('role') === 'pengelola' ? 'checked' : '' }}
                           class="sr-only peer" onchange="updateRoleCards()">
                    <div class="p-4 rounded-xl border-2 transition-all duration-200 bg-[#0F1729]
                                peer-checked:border-[#E8734A] peer-checked:bg-[#E8734A]/5
                                border-[#1E2E4A] group-hover:border-[#2A3E5A]">
                        <div class="w-8 h-8 rounded-lg bg-[#1A2540] flex items-center justify-center mb-2.5">
                            <svg class="w-4 h-4 text-[#6B7A99]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="text-sm font-semibold text-[#C4CBDC] mb-0.5">Pengelola</div>
                        <div class="text-xs text-[#6B7A99]">Kelola event</div>
                    </div>
                </label>
            </div>
            @error('role')
                <p class="flex items-center gap-1.5 text-xs text-red-400">
                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="space-y-1.5">
            <label for="password" class="block text-sm font-medium text-[#C4CBDC]">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#4A556B]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" type="password" name="password"
                       required autocomplete="new-password"
                       placeholder="Min. 8 karakter"
                       class="w-full pl-10 pr-11 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#3A4560] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0
                              {{ $errors->has('password') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-[#1E2E4A] hover:border-[#2A3E5A] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/15' }}">
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
                <p class="flex items-center gap-1.5 text-xs text-red-400">
                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="space-y-1.5">
            <label for="password_confirmation" class="block text-sm font-medium text-[#C4CBDC]">Konfirmasi Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#4A556B]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       required autocomplete="new-password"
                       placeholder="Ulangi password"
                       class="w-full pl-10 pr-11 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#3A4560] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0
                              {{ $errors->has('password_confirmation') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-[#1E2E4A] hover:border-[#2A3E5A] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/15' }}">
                <button type="button" onclick="togglePassword('password_confirmation', this)"
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
            @error('password_confirmation')
                <p class="flex items-center gap-1.5 text-xs text-red-400">
                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full py-3 px-4 bg-[#E8734A] hover:bg-[#D4623C] active:bg-[#C05530] text-white font-semibold text-sm rounded-xl transition-all duration-200 shadow-lg shadow-[#E8734A]/20 hover:shadow-[#E8734A]/30 focus:outline-none focus:ring-2 focus:ring-[#E8734A]/50 focus:ring-offset-2 focus:ring-offset-[#0A1120] group">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Buat Akun
            </span>
        </button>

        {{-- Terms note --}}
        <p class="text-center text-xs text-[#4A556B]">
            Dengan mendaftar, kamu menyetujui
            <span class="text-[#6B7A99]">Syarat & Ketentuan</span> penggunaan platform ini.
        </p>
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
