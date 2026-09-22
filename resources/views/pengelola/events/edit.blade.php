<x-layouts.dashboard :title="'Edit Event'">

<div class="max-w-2xl">
    <form method="POST" action="{{ route('pengelola.events.update', $event) }}" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-ink-secondary mb-1.5">Judul Event <span class="text-coral">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" placeholder="Nama event"
                   class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('title') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
            @error('title')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        {{-- Location --}}
        <div>
            <label for="location" class="block text-sm font-medium text-ink-secondary mb-1.5">Lokasi <span class="text-coral">*</span></label>
            <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}" placeholder="Tempat pelaksanaan"
                   class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('location') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
            @error('location')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        {{-- Capacity --}}
        <div>
            <label for="capacity" class="block text-sm font-medium text-ink-secondary mb-1.5">Kapasitas <span class="text-coral">*</span></label>
            <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $event->capacity) }}" min="1" placeholder="100"
                   class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('capacity') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
            @error('capacity')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        {{-- Category --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-ink-secondary mb-1.5">Kategori <span class="text-coral">*</span></label>
            <select id="category_id" name="category_id"
                    class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('category_id') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
                <option value="">Pilih kategori</option>
                @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $event->category_id) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        {{-- Dates --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-ink-secondary mb-1.5">Tanggal Mulai <span class="text-coral">*</span></label>
                <input type="datetime-local" id="start_date" name="start_date"
                       value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}"
                       class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('start_date') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
                @error('start_date')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-ink-secondary mb-1.5">Tanggal Selesai</label>
                <input type="datetime-local" id="end_date" name="end_date"
                       value="{{ old('end_date', $event->end_date?->format('Y-m-d\TH:i')) }}"
                       class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('end_date') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
                @error('end_date')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-ink-secondary mb-1.5">Status <span class="text-coral">*</span></label>
            <select id="status" name="status"
                    class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('status') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
                <option value="upcoming"  @selected(old('status', $event->status) === 'upcoming')>Akan Datang</option>
                <option value="ongoing"   @selected(old('status', $event->status) === 'ongoing')>Sedang Berlangsung</option>
                <option value="completed" @selected(old('status', $event->status) === 'completed')>Selesai</option>
                <option value="canceled"  @selected(old('status', $event->status) === 'canceled')>Dibatalkan</option>
            </select>
            @error('status')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-ink-secondary mb-1.5">Deskripsi <span class="text-coral">*</span></label>
            <textarea id="description" name="description" rows="5" placeholder="Deskripsi singkat event..."
                      class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('description') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 resize-none">{{ old('description', $event->description) }}</textarea>
            @error('description')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('pengelola.events.show', $event) }}"
               class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-sm text-ink-secondary transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">
                Perbarui Event
            </button>
        </div>
    </form>
</div>

</x-layouts.dashboard>
