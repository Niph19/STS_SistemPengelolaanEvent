<x-layouts.guest :title="'Daftar Akun'">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#F5F3EE] tracking-tight mb-1">Buat akun baru</h1>
        <p class="text-sm text-[#9BA3B8]">Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#E8734A] hover:text-[#F2A671] font-medium transition-colors">Masuk di sini</a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-[#F5F3EE] mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#64748B] transition-colors focus:outline-none focus:ring-1
                          {{ $errors->has('name') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-white/[0.08] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20' }}"
                   placeholder="Ahmad Fauzi">
            @error('name')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-[#F5F3EE] mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#64748B] transition-colors focus:outline-none focus:ring-1
                          {{ $errors->has('email') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-white/[0.08] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20' }}"
                   placeholder="nama@email.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block text-sm font-medium text-[#F5F3EE] mb-1.5">Daftar sebagai</label>
            <select id="role" name="role" required
                    class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] transition-colors focus:outline-none focus:ring-1
                           {{ $errors->has('role') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-white/[0.08] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20' }}">
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role...</option>
                <option value="peserta"   {{ old('role') === 'peserta'   ? 'selected' : '' }}>Peserta — Ikuti event</option>
                <option value="pengelola" {{ old('role') === 'pengelola' ? 'selected' : '' }}>Pengelola — Kelola event</option>
            </select>
            @error('role')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-[#F5F3EE] mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#64748B] transition-colors focus:outline-none focus:ring-1
                          {{ $errors->has('password') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-white/[0.08] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20' }}"
                   placeholder="Min. 8 karakter">
            @error('password')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-[#F5F3EE] mb-1.5">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#64748B] transition-colors focus:outline-none focus:ring-1
                          {{ $errors->has('password_confirmation') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-white/[0.08] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20' }}"
                   placeholder="Ulangi password">
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full py-2.5 px-4 bg-[#E8734A] hover:bg-[#F2A671] text-white font-semibold text-sm rounded-xl transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-[#E8734A]/50 focus:ring-offset-2 focus:ring-offset-[#1A2540]">
            Buat Akun
        </button>
    </form>

</x-layouts.guest>
