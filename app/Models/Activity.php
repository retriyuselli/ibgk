<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'activity_date',
        'end_date',
        'location',
        'thumbnail',
        'banner',
        'is_featured',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'end_date' => 'date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Activity $activity): void {
            if ($activity->is_published && blank($activity->published_at)) {
                $activity->published_at = now();
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->where(function (Builder $builder): void {
                $builder->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ActivityCategory::class, 'activity_category_id');
    }

    public function activityCategory(): BelongsTo
    {
        return $this->category();
    }
}
