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
}
