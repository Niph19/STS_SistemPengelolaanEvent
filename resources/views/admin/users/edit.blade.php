<x-layouts.dashboard :title="'Edit User'">

<div class="max-w-lg">
    {{-- Back --}}
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-ink-secondary hover:text-ink-primary mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar User
    </a>

    {{-- User Header Card --}}
    <div class="flex items-center gap-4 p-5 rounded-2xl bg-navy-surface border border-navy-border mb-6">
        <div class="w-12 h-12 rounded-full bg-coral/20 flex items-center justify-center shrink-0">
            <span class="text-coral text-lg font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
        </div>
        <div>
            <p class="text-base font-semibold text-ink-primary">{{ $user->name }}</p>
            <p class="text-sm text-ink-muted">{{ $user->email }}</p>
        </div>
    </div>

    <div class="p-6 rounded-2xl bg-navy-surface border border-navy-border">
        <h2 class="text-base font-semibold text-ink-primary mb-1">Edit Data User</h2>
        <p class="text-sm text-ink-muted mb-6">Ubah informasi akun user. Kosongkan field password jika tidak ingin mengubahnya.</p>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PATCH')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-ink-primary mb-1.5">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1
                              {{ $errors->has('name') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-navy-border focus:border-coral/50 focus:ring-coral/20' }}">
                @error('name')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-ink-primary mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1
                              {{ $errors->has('email') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-navy-border focus:border-coral/50 focus:ring-coral/20' }}">
                @error('email')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block text-sm font-medium text-ink-primary mb-1.5">Role</label>
                <select id="role" name="role" required
                        class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-ink-primary transition-colors focus:outline-none focus:ring-1
                               {{ $errors->has('role') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-navy-border focus:border-coral/50 focus:ring-coral/20' }}">
                    <option value="peserta"   {{ old('role', $user->role) === 'peserta'   ? 'selected' : '' }}>Peserta</option>
                    <option value="pengelola" {{ old('role', $user->role) === 'pengelola' ? 'selected' : '' }}>Pengelola</option>
                    <option value="admin"     {{ old('role', $user->role) === 'admin'     ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-ink-primary mb-1.5">Nomor Telepon <span class="text-ink-muted font-normal">(opsional)</span></label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border border-navy-border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1 focus:border-coral/50 focus:ring-coral/20"
                       placeholder="08xxxxxxxxxx">
                @error('phone')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Divider --}}
            <div class="border-t border-navy-border pt-4">
                <p class="text-xs text-ink-muted mb-4">Ubah password (kosongkan jika tidak ingin mengubah)</p>

                {{-- New Password --}}
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-ink-primary mb-1.5">Password Baru</label>
                        <input id="password" type="password" name="password" autocomplete="new-password"
                               class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1
                                      {{ $errors->has('password') ? 'border-red-500/60 focus:border-red-500/60 focus:ring-red-500/30' : 'border-navy-border focus:border-coral/50 focus:ring-coral/20' }}"
                               placeholder="Min. 8 karakter">
                        @error('password')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-ink-primary mb-1.5">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                               class="w-full px-4 py-2.5 rounded-xl bg-[#0F1729] border border-navy-border text-sm text-ink-primary placeholder:text-ink-muted transition-colors focus:outline-none focus:ring-1 focus:border-coral/50 focus:ring-coral/20"
                               placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            {{-- Self-edit warning --}}
            @if($user->id === auth()->id())
                <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-yellow-500/10 border border-yellow-500/20 text-yellow-300 text-xs">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Kamu sedang mengedit akun milikmu sendiri.
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                        class="px-5 py-2.5 bg-coral hover:bg-coral-hover text-white font-semibold text-sm rounded-xl transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-ink-primary font-medium text-sm rounded-xl transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

</x-layouts.dashboard>
