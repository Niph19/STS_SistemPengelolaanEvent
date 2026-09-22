<x-guest-layout title="Konfirmasi Password">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#F5F3EE] tracking-tight mb-1">Konfirmasi Password</h1>
        <p class="text-sm text-[#9BA3B8]">Ini area aman. Konfirmasi password kamu sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="block text-sm font-medium text-[#C4CBDC] mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-[#F5F3EE] placeholder:text-[#3A4560] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0
                          {{ $errors->has('password') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-[#1E2E4A] hover:border-[#2A3E5A] focus:border-[#E8734A]/50 focus:ring-[#E8734A]/15' }}"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full py-3 px-4 bg-[#E8734A] hover:bg-[#D4623C] text-white font-semibold text-sm rounded-xl transition-all duration-200 shadow-lg shadow-[#E8734A]/20">
            Konfirmasi
        </button>
    </form>

</x-guest-layout>
