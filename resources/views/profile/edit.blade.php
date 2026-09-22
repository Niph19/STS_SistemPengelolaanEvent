<x-layouts.dashboard :title="'Profil Saya'">

<div class="space-y-6 max-w-2xl">

    {{-- Update Profile Info --}}
    <div class="p-6 rounded-2xl bg-navy-surface border border-navy-border">
        <h2 class="text-base font-semibold text-ink-primary mb-1">Informasi Profil</h2>
        <p class="text-sm text-ink-muted mb-6">Perbarui nama, email, nomor telepon, dan alamat akun kamu.</p>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('PATCH')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-ink-primary mb-1.5">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required autocomplete="name"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1
                              {{ $errors->has('name') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-navy-border focus:border-coral/50 focus:ring-coral/20' }}">
                @error('name')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-ink-primary mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="username"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1
                              {{ $errors->has('email') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-navy-border focus:border-coral/50 focus:ring-coral/20' }}">
                @error('email')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-ink-primary mb-1.5">Nomor Telepon <span class="text-ink-muted font-normal">(opsional)</span></label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" autocomplete="tel"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border border-navy-border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1 focus:border-coral/50 focus:ring-coral/20"
                       placeholder="08xxxxxxxxxx">
                @error('phone')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="block text-sm font-medium text-ink-primary mb-1.5">Alamat <span class="text-ink-muted font-normal">(opsional)</span></label>
                <textarea id="address" name="address" rows="3" autocomplete="street-address"
                          class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border border-navy-border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1 focus:border-coral/50 focus:ring-coral/20 resize-none"
                          placeholder="Jl. Merdeka No. 1, Jakarta">{{ old('address', auth()->user()->address) }}</textarea>
                @error('address')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Verified Badge --}}
            @if(auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div class="flex items-start gap-3 p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/20">
                    <svg class="w-4 h-4 text-yellow-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="text-sm">
                        <p class="text-yellow-300 font-medium">Email belum diverifikasi.</p>
                        <button form="send-verification" class="text-yellow-400 hover:underline text-xs mt-0.5">Kirim ulang email verifikasi</button>
                    </div>
                </div>
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>
            @endif

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2.5 bg-coral hover:bg-coral-hover text-white font-semibold text-sm rounded-xl transition-colors">
                    Simpan Perubahan
                </button>
                @if(session('status') === 'profile-updated')
                    <span class="text-sm text-emerald-400">Tersimpan.</span>
                @endif
            </div>
        </form>
    </div>

    {{-- Update Password --}}
    <div class="p-6 rounded-2xl bg-navy-surface border border-navy-border">
        <h2 class="text-base font-semibold text-ink-primary mb-1">Ubah Password</h2>
        <p class="text-sm text-ink-muted mb-6">Pastikan menggunakan password yang panjang dan acak agar tetap aman.</p>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Current Password --}}
            <div>
                <label for="current_password" class="block text-sm font-medium text-ink-primary mb-1.5">Password Saat Ini</label>
                <input id="current_password" type="password" name="current_password" autocomplete="current-password"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1
                              {{ $errors->updatePassword->has('current_password') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-navy-border focus:border-coral/50 focus:ring-coral/20' }}"
                       placeholder="••••••••">
                @if($errors->updatePassword->has('current_password'))
                    <p class="mt-1.5 text-xs text-red-400">{{ $errors->updatePassword->first('current_password') }}</p>
                @endif
            </div>

            {{-- New Password --}}
            <div>
                <label for="new_password" class="block text-sm font-medium text-ink-primary mb-1.5">Password Baru</label>
                <input id="new_password" type="password" name="password" autocomplete="new-password"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1
                              {{ $errors->updatePassword->has('password') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-navy-border focus:border-coral/50 focus:ring-coral/20' }}"
                       placeholder="Min. 8 karakter">
                @if($errors->updatePassword->has('password'))
                    <p class="mt-1.5 text-xs text-red-400">{{ $errors->updatePassword->first('password') }}</p>
                @endif
            </div>

            {{-- Confirm New Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-ink-primary mb-1.5">Konfirmasi Password Baru</label>
                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border border-navy-border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1 focus:border-coral/50 focus:ring-coral/20"
                       placeholder="Ulangi password baru">
                @if($errors->updatePassword->has('password_confirmation'))
                    <p class="mt-1.5 text-xs text-red-400">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2.5 bg-coral hover:bg-coral-hover text-white font-semibold text-sm rounded-xl transition-colors">
                    Perbarui Password
                </button>
                @if(session('status') === 'password-updated')
                    <span class="text-sm text-emerald-400">Tersimpan.</span>
                @endif
            </div>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="p-6 rounded-2xl bg-navy-surface border border-red-500/20" x-data="{ showConfirm: false }">
        <h2 class="text-base font-semibold text-red-400 mb-1">Hapus Akun</h2>
        <p class="text-sm text-ink-muted mb-5">Setelah dihapus, semua data dan resource akun ini akan dihapus permanen. Pastikan kamu telah menyimpan semua data penting sebelum melanjutkan.</p>

        <button @click="showConfirm = true"
                class="px-5 py-2.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 font-semibold text-sm rounded-xl transition-colors">
            Hapus Akun
        </button>

        {{-- Confirm Modal --}}
        <div x-show="showConfirm" style="display:none"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="w-full max-w-sm bg-navy-surface border border-red-500/20 rounded-2xl p-6 shadow-2xl"
                 @click.outside="showConfirm = false">
                <h3 class="text-base font-semibold text-red-400 mb-2">Konfirmasi Hapus Akun</h3>
                <p class="text-sm text-ink-muted mb-5">Masukkan password untuk mengkonfirmasi penghapusan. Tindakan ini tidak dapat dibatalkan.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('DELETE')
                    <input type="password" name="password" placeholder="Password kamu" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border border-red-500/30 text-sm text-ink-primary placeholder:text-ink-muted focus:outline-none focus:ring-1 focus:border-red-500/60 focus:ring-red-500/20">
                    @if($errors->userDeletion->has('password'))
                        <p class="text-xs text-red-400">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                    <div class="flex items-center gap-3 pt-1">
                        <button type="submit" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold text-sm rounded-xl transition-colors">
                            Ya, Hapus Akun
                        </button>
                        <button type="button" @click="showConfirm = false"
                                class="flex-1 py-2.5 bg-white/5 hover:bg-white/10 text-ink-primary font-medium text-sm rounded-xl transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

</x-layouts.dashboard>
