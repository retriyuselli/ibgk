<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
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

    public function members(): HasMany
    {
        return $this->hasMany(OrganizationMember::class);
    }

    public function isChair(): bool
    {
        $haystack = strtolower(trim($this->slug.' '.$this->name));

        if (str_contains($haystack, 'wakil') || str_contains($haystack, 'bidang')) {
            return false;
        }

        return str_contains($haystack, 'ketua-umum')
            || str_contains($haystack, 'ketua umum')
            || $this->slug === 'ketua';
    }

    public function isCoreOfficer(): bool
    {
        if ($this->isChair()) {
            return false;
        }

        $haystack = strtolower(trim($this->slug.' '.$this->name));

        foreach (['wakil', 'sekretaris', 'bendahara', 'humas', 'publikasi'] as $needle) {
            if (str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    public function isDivisionLead(): bool
    {
        $haystack = strtolower(trim($this->slug.' '.$this->name));

        return str_contains($haystack, 'bidang') || str_contains($haystack, 'divisi') || str_contains($haystack, 'departemen');
    }

    public function isMember(): bool
    {
        if ($this->isChair() || $this->isCoreOfficer() || $this->isDivisionLead()) {
            return false;
        }

        $haystack = strtolower(trim($this->slug.' '.$this->name));

        return $this->slug === 'anggota' || str_contains($haystack, 'anggota');
    }

    public function requiresDivision(): bool
    {
        return $this->isDivisionLead() || $this->isMember();
    }
}
