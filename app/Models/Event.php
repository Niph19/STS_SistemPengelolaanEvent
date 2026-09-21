<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'pengelola_id',
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'capacity',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'capacity' => 'integer',
        ];
    }

    /**
     * Relasi ke kategori event.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relasi ke pengelola event (User dengan role pengelola/admin).
     */
    public function pengelola(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengelola_id');
    }

    /**
     * Relasi ke seluruh data registrasi pendaftaran pada event ini.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'event_id');
    }

    /**
     * Relasi Many-to-Many ke peserta (User) yang mendaftar pada event ini.
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'registrations', 'event_id', 'user_id')
            ->withPivot('id', 'status', 'registered_at')
            ->withTimestamps();
    }

    /**
     * Scope query untuk filter pencarian, kategori, dan status event.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($filters['category_id'] ?? null, function (Builder $query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($filters['status'] ?? null, function (Builder $query, string $status) {
                $query->where('status', $status);
            });
    }

    /**
     * Menghitung sisa kuota yang masih tersedia berdasarkan pendaftaran yang disetujui.
     */
    public function getRemainingQuotaAttribute(): int
    {
        $approvedCount = $this->relationLoaded('registrations')
            ? $this->registrations->where('status', 'approved')->count()
            : $this->registrations()->where('status', 'approved')->count();

        return max(0, $this->capacity - $approvedCount);
    }
}
