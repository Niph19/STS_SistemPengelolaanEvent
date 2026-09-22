<x-layouts.guest :title="'Verifikasi Email'">

    <div class="mb-8 text-center">
        <div class="w-14 h-14 rounded-full bg-[#E8734A]/10 border border-[#E8734A]/20 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-[#E8734A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-[#F5F3EE] tracking-tight mb-2">Verifikasi Email</h1>
        <p class="text-sm text-[#9BA3B8] max-w-sm mx-auto">
            Terima kasih sudah mendaftar! Klik tautan verifikasi yang sudah kami kirimkan ke emailmu untuk mulai menggunakan akun.
        </p>
    </div>

    @if(session('status') === 'verification-link-sent')
        <div class="mb-5 flex items-center gap-2 px-4 py-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Link verifikasi baru sudah dikirimkan ke emailmu.
        </div>
    @endif

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="w-full py-2.5 px-4 bg-[#E8734A] hover:bg-[#F2A671] text-white font-semibold text-sm rounded-xl transition-colors">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full py-2.5 px-4 bg-white/5 hover:bg-white/10 text-[#9BA3B8] hover:text-[#F5F3EE] font-medium text-sm rounded-xl transition-colors">
                Keluar
            </button>
        </form>
    </div>

</x-layouts.guest>
