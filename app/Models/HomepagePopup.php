<?php

namespace App\Models;

use App\Support\SafeUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HomepagePopup extends Model
{
    protected $fillable = [
        'title',
        'body',
        'image',
        'button_label',
        'button_url',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        $now = now();

        return $query
            ->where('is_active', true)
            ->where(function (Builder $builder) use ($now): void {
                $builder->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function (Builder $builder) use ($now): void {
                $builder->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            });
    }

    public static function current(): ?self
    {
        return static::query()
            ->active()
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->latest('updated_at')
            ->first();
    }

    public function imageUrl(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        return asset('storage/'.$this->image);
    }

    public function buttonHref(): ?string
    {
        $url = trim((string) $this->button_url);

        if ($url === '') {
            return null;
        }

        if (str_starts_with($url, '/')) {
            return $url;
        }

        return SafeUrl::forHref($url);
    }

    public function buttonText(): string
    {
        return filled($this->button_label) ? $this->button_label : 'Selengkapnya';
    }

    public function dismissKey(): string
    {
        $stamp = $this->updated_at?->timestamp ?? $this->id;

        return 'ibgk-home-popup-'.$this->id.'-'.$stamp;
    }
}
