<x-layouts.dashboard :title="'Detail User'">

<div class="max-w-xl space-y-5">
    {{-- Actions --}}
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.users.edit', $user) }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-navy-surface border border-navy-border hover:border-coral/40 text-ink-secondary hover:text-coral text-sm rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
        @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Hapus user ini?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500/10 border border-red-500/20 hover:border-red-500/40 text-red-400 text-sm rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </button>
            </form>
        @endif
    </div>

    {{-- Profile Card --}}
    <div class="p-6 rounded-2xl bg-navy-surface border border-navy-border">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-full bg-coral/20 flex items-center justify-center shrink-0">
                <span class="text-coral text-xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-ink-primary">{{ $user->name }}</h2>
                <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-full mt-1
                    @if($user->role === 'admin') bg-purple-500/15 text-purple-300
                    @elseif($user->role === 'pengelola') bg-blue-500/15 text-blue-300
                    @else bg-coral/15 text-coral @endif">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <dl class="space-y-4">
            <div>
                <dt class="text-xs text-ink-muted mb-0.5">Email</dt>
                <dd class="text-sm text-ink-primary">{{ $user->email }}</dd>
            </div>
            @if($user->phone)
            <div>
                <dt class="text-xs text-ink-muted mb-0.5">Nomor HP</dt>
                <dd class="text-sm text-ink-primary">{{ $user->phone }}</dd>
            </div>
            @endif
            @if($user->address)
            <div>
                <dt class="text-xs text-ink-muted mb-0.5">Alamat</dt>
                <dd class="text-sm text-ink-primary">{{ $user->address }}</dd>
            </div>
            @endif
            <div>
                <dt class="text-xs text-ink-muted mb-0.5">Bergabung</dt>
                <dd class="text-sm text-ink-primary">{{ $user->created_at->isoFormat('D MMMM YYYY') }}</dd>
            </div>
        </dl>
    </div>
</div>

</x-layouts.dashboard>
