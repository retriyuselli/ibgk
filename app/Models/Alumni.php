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
        'profile_token',
        'profile_token_expires_at',
        'profile_invited_at',
        'profile_submitted_at',
        'is_public',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'graduation_year' => 'integer',
            'profile_token_expires_at' => 'datetime',
            'profile_invited_at' => 'datetime',
            'profile_submitted_at' => 'datetime',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function profileFormUrl(): string
    {
        return route('alumni.profile.form', $this->profile_token);
    }

    public function hasValidProfileToken(): bool
    {
        if (blank($this->profile_token)) {
            return false;
        }

        if ($this->profile_token_expires_at === null) {
            return true;
        }

        return $this->profile_token_expires_at->isFuture();
    }

    public function profileFormStatusLabel(): string
    {
        if ($this->profile_submitted_at) {
            return 'Sudah diisi';
        }

        if ($this->hasValidProfileToken()) {
            return 'Menunggu pengisian';
        }

        if (filled($this->profile_token)) {
            return 'Link kedaluwarsa';
        }

        return 'Belum dikirim';
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
