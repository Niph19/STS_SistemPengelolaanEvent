<x-layouts.guest :title="'Reset Password'">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#F5F3EE] tracking-tight mb-1">Buat password baru</h1>
        <p class="text-sm text-[#9BA3B8]">Pastikan password baru kamu cukup kuat dan mudah diingat.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-[#F5F3EE] mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#64748B] transition-colors focus:outline-none focus:ring-1
                          {{ $errors->has('email') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-white/[0.08] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20' }}">
            @error('email')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- New Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-[#F5F3EE] mb-1.5">Password Baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#64748B] transition-colors focus:outline-none focus:ring-1
                          {{ $errors->has('password') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-white/[0.08] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20' }}"
                   placeholder="Min. 8 karakter">
            @error('password')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-[#F5F3EE] mb-1.5">Konfirmasi Password Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border border-white/[0.08] text-sm text-[#F5F3EE] placeholder:text-[#64748B] transition-colors focus:outline-none focus:ring-1 focus:border-[#E8734A]/50 focus:ring-[#E8734A]/20"
                   placeholder="Ulangi password baru">
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full py-2.5 px-4 bg-[#E8734A] hover:bg-[#F2A671] text-white font-semibold text-sm rounded-xl transition-colors">
            Reset Password
        </button>
    </form>

</x-layouts.guest>
