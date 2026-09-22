<x-layouts.guest :title="'Lupa Password'">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#F5F3EE] tracking-tight mb-1">Lupa password?</h1>
        <p class="text-sm text-[#9BA3B8]">Masukkan emailmu dan kami akan mengirimkan link untuk reset password.</p>
    </div>

    @if(session('status'))
        <div class="mb-5 flex items-center gap-2 px-4 py-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-[#C4CBDC] mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#3A4560] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0
                          {{ $errors->has('email') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-[#1E2E4A] hover:border-[#2A3E5A] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/15' }}"
                   placeholder="nama@email.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full py-3 px-4 bg-[#E8734A] hover:bg-[#D4623C] text-white font-semibold text-sm rounded-xl transition-all duration-200 shadow-lg shadow-[#E8734A]/20">
            Kirim Link Reset Password
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-[#6B7A99] hover:text-[#E8734A] transition-colors">
                ← Kembali ke halaman masuk
            </a>
        </div>
    </form>

</x-layouts.guest>
