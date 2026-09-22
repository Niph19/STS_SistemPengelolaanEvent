<x-layouts.dashboard :title="'Kelola User'">

<div class="space-y-5">
    {{-- Header --}}
    <div class="flex justify-end">
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah User
        </a>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ink-muted pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-navy-surface border border-navy-border text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
        </div>
        <select name="role"
                class="px-4 py-2.5 rounded-xl bg-navy-surface border border-navy-border text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30"
                onchange="this.form.submit()">
            <option value="">Semua Role</option>
            <option value="admin"     @selected(request('role') === 'admin')>Admin</option>
            <option value="pengelola" @selected(request('role') === 'pengelola')>Pengelola</option>
            <option value="peserta"   @selected(request('role') === 'peserta')>Peserta</option>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">Cari</button>
    </form>

    {{-- Table --}}
    @if(isset($users) && $users->count())
        {{-- Mobile Cards --}}
        <div class="space-y-3 lg:hidden">
            @foreach($users as $user)
                <div class="p-4 rounded-xl bg-navy-surface border border-navy-border">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-full bg-coral/20 flex items-center justify-center shrink-0">
                            <span class="text-coral text-sm font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-ink-primary truncate">{{ $user->name }}</p>
                            <p class="text-xs text-ink-muted truncate">{{ $user->email }}</p>
                        </div>
                        <span class="shrink-0 text-xs px-2.5 py-1 rounded-full
                            @if($user->role === 'admin') bg-purple-500/15 text-purple-300
                            @elseif($user->role === 'pengelola') bg-blue-500/15 text-blue-300
                            @else bg-coral/15 text-coral @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3 text-xs">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-ink-secondary hover:text-coral transition-colors">Detail</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-ink-secondary hover:text-coral transition-colors">Edit</a>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:underline">Hapus</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Desktop Table --}}
        <div class="hidden lg:block overflow-x-auto rounded-xl border border-navy-border">
            <table class="w-full text-sm text-left">
                <thead class="bg-navy-surface text-xs text-ink-muted uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Role</th>
                        <th class="px-5 py-3">Bergabung</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-border">
                    @foreach($users as $user)
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-coral/20 flex items-center justify-center shrink-0">
                                        <span class="text-coral text-xs font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <span class="font-medium text-ink-primary">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $user->email }}</td>
                            <td class="px-5 py-4">
                                <span class="text-xs px-2.5 py-1 rounded-full
                                    @if($user->role === 'admin') bg-purple-500/15 text-purple-300
                                    @elseif($user->role === 'pengelola') bg-blue-500/15 text-blue-300
                                    @else bg-coral/15 text-coral @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-ink-secondary">{{ $user->created_at->isoFormat('D MMM YYYY') }}</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-ink-secondary hover:text-coral transition-colors text-xs">Detail</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-ink-secondary hover:text-coral transition-colors text-xs">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:underline text-xs">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="mt-4">{{ $users->links() }}</div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center py-16 rounded-xl bg-navy-surface border border-navy-border border-dashed">
            <svg class="w-10 h-10 text-ink-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <p class="text-sm text-ink-muted">Tidak ada user ditemukan</p>
        </div>
    @endif
</div>

</x-layouts.dashboard>
