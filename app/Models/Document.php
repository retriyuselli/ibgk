<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'file',
        'description',
        'is_public',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true)->where('is_active', true);
    }

    /**
     * Disk penyimpanan file dokumen.
     * Semua file disimpan di disk local (private) agar tidak dapat diakses
     * langsung via URL /storage. Flag is_public hanya menandai niat akses
     * publik nanti melalui route download terkontrol (belum dibuat).
     */
    public static function storageDisk(): string
    {
        return 'local';
    }
}
