@php
$fields = [
    ['name' => 'title',       'label' => 'Judul Event',    'type' => 'text',     'required' => true,  'placeholder' => 'Nama event'],
    ['name' => 'location',    'label' => 'Lokasi',         'type' => 'text',     'required' => true,  'placeholder' => 'Tempat pelaksanaan'],
    ['name' => 'capacity',    'label' => 'Kapasitas',      'type' => 'number',   'required' => true,  'placeholder' => '100'],
];
@endphp

<x-layouts.dashboard :title="'Tambah Event'">

<div class="max-w-2xl">
    <form method="POST" action="{{ route('pengelola.events.store') }}" class="space-y-5">
        @csrf

        @foreach($fields as $f)
            <div>
                <label for="{{ $f['name'] }}" class="block text-sm font-medium text-ink-secondary mb-1.5">
                    {{ $f['label'] }} @if($f['required'])<span class="text-coral">*</span>@endif
                </label>
                <input type="{{ $f['type'] }}" id="{{ $f['name'] }}" name="{{ $f['name'] }}"
                       value="{{ old($f['name']) }}"
                       placeholder="{{ $f['placeholder'] }}"
                       class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error($f['name']) border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 transition-colors">
                @error($f['name'])
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        {{-- Category --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-ink-secondary mb-1.5">Kategori <span class="text-coral">*</span></label>
            <select id="category_id" name="category_id"
                    class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('category_id') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
                <option value="">Pilih kategori</option>
                @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        {{-- Dates --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-ink-secondary mb-1.5">Tanggal Mulai <span class="text-coral">*</span></label>
                <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}"
                       class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('start_date') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
                @error('start_date')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-ink-secondary mb-1.5">Tanggal Selesai</label>
                <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}"
                       class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('end_date') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
                @error('end_date')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-ink-secondary mb-1.5">Status <span class="text-coral">*</span></label>
            <select id="status" name="status"
                    class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('status') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary focus:border-coral/40 focus:ring-1 focus:ring-coral/30">
                <option value="upcoming"  @selected(old('status', 'upcoming') === 'upcoming')>Akan Datang</option>
                <option value="ongoing"   @selected(old('status') === 'ongoing')>Sedang Berlangsung</option>
                <option value="completed" @selected(old('status') === 'completed')>Selesai</option>
                <option value="canceled"  @selected(old('status') === 'canceled')>Dibatalkan</option>
            </select>
            @error('status')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-ink-secondary mb-1.5">Deskripsi <span class="text-coral">*</span></label>
            <textarea id="description" name="description" rows="5" placeholder="Deskripsi singkat event..."
                      class="w-full px-4 py-2.5 rounded-xl bg-navy-surface border @error('description') border-red-500/60 @else border-navy-border @enderror text-sm text-ink-primary placeholder:text-ink-muted focus:border-coral/40 focus:ring-1 focus:ring-coral/30 resize-none">{{ old('description') }}</textarea>
            @error('description')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('pengelola.events.index') }}"
               class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-sm text-ink-secondary transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-coral hover:bg-coral-hover text-white text-sm font-semibold rounded-xl transition-colors">
                Simpan Event
            </button>
        </div>
    </form>
</div>

</x-layouts.dashboard>
