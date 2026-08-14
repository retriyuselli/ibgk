<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_year',
        'end_year',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_year' => 'integer',
            'end_year' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (OrganizationPeriod $period): void {
            if (! $period->is_active) {
                return;
            }

            static::query()
                ->when(
                    $period->exists,
                    fn ($query) => $query->whereKeyNot($period->getKey()),
                )
                ->where('is_active', true)
                ->update(['is_active' => false]);
        });
    }

    public function yearRange(): string
    {
        if ($this->start_year && $this->end_year) {
            return $this->start_year.' - '.$this->end_year;
        }

        if ($this->start_year) {
            return (string) $this->start_year;
        }

        return title_case($this->name) ?: 'Periode Aktif';
    }

    public function members(): HasMany
    {
        return $this->hasMany(OrganizationMember::class);
    }
}
