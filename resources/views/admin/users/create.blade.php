<x-layouts.dashboard :title="'Tambah User'">

<div class="max-w-lg">
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-ink-secondary mb-1.5">Nama Lengkap <span class="text-coral">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap"
                   class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('name') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
            @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-ink-secondary mb-1.5">Email <span class="text-coral">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                   class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('email') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
            @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-ink-secondary mb-1.5">Role <span class="text-coral">*</span></label>
            <select id="role" name="role"
                    class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('role') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
                <option value="">Pilih role</option>
                <option value="admin"     @selected(old('role') === 'admin')>Admin</option>
                <option value="pengelola" @selected(old('role') === 'pengelola')>Pengelola</option>
                <option value="peserta"   @selected(old('role') === 'peserta')>Peserta</option>
            </select>
            @error('role')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-ink-secondary mb-1.5">Nomor HP</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xx-xxxx-xxxx"
                   class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('phone') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
            @error('phone')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-ink-secondary mb-1.5">Alamat</label>
            <textarea id="address" name="address" rows="2" placeholder="Alamat lengkap"
                      class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('address') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 resize-none">{{ old('address') }}</textarea>
            @error('address')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-medium text-ink-secondary mb-1.5">Password <span class="text-coral">*</span></label>
                <input type="password" id="password" name="password" placeholder="Min. 8 karakter"
                       class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('password') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
                @error('password')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-ink-secondary mb-1.5">Konfirmasi Password <span class="text-coral">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password"
                       class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border border-navy-border text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.users.index') }}"
               class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-sm text-ink-secondary transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">
                Simpan User
            </button>
        </div>
    </form>
</div>

</x-layouts.dashboard>
