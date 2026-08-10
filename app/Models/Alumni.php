<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'alumni_batch_id',
        'participant_id',
        'gender',
        'name',
        'slug',
        'photo',
        'university',
        'faculty',
        'study_program',
        'graduation_year',
        'profession',
        'company',
        'city',
        'bio',
        'instagram',
        'linkedin',
        'email',
        'phone',
        'is_public',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'graduation_year' => 'integer',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function batch(): BelongsTo
    {
        return $this->alumniBatch();
    }

    public function alumniBatch(): BelongsTo
    {
        return $this->belongsTo(AlumniBatch::class, 'alumni_batch_id');
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function organizationMembers(): HasMany
    {
        return $this->hasMany(OrganizationMember::class);
    }
}
