<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'location',
        'is_featured',
        'is_published',
        'published_at',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'views' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (News $news): void {
            if ($news->is_published && blank($news->published_at)) {
                $news->published_at = now();
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
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function newsCategory(): BelongsTo
    {
        return $this->category();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->author();
    }
}
