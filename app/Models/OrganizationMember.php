<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_period_id',
        'organization_position_id',
        'alumni_id',
        'name',
        'photo',
        'email',
        'phone',
        'bio',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(OrganizationPeriod::class, 'organization_period_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(OrganizationPosition::class, 'organization_position_id');
    }

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    public function displayName(): string
    {
        return title_case($this->name) ?: title_case($this->alumni?->name);
    }

    public function displayPosition(): string
    {
        return title_case($this->position?->name) ?: 'Pengurus';
    }

    public function displayUniversity(): string
    {
        return title_case($this->alumni?->university);
    }

    public function displaySubtitle(): string
    {
        $alumni = $this->alumni;

        if ($alumni) {
            $year = $alumni->alumniBatch?->year ?? $alumni->graduation_year;
            $label = $alumni->genderLabel().' Sumatera Selatan';

            return $year ? $label.' '.$year : $label;
        }

        if (filled($this->bio)) {
            return \Illuminate\Support\Str::limit(trim(strip_tags($this->bio)), 72);
        }

        return 'Pengurus IBGK Sumatera Selatan';
    }

    public function photoPath(): ?string
    {
        return filled($this->photo) ? $this->photo : $this->alumni?->photo;
    }
}
