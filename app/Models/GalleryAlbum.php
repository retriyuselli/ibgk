<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'cover',
        'event_date',
        'location',
        'is_featured',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class);
    }

    public function galleryPhotos(): HasMany
    {
        return $this->photos();
    }
}
