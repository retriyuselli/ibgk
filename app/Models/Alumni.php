<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'user_id',
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

    public function isGadis(): bool
    {
        return in_array($this->gender, ['gadis', 'female'], true);
    }

    public function isBujang(): bool
    {
        return in_array($this->gender, ['bujang', 'male'], true);
    }

    public function genderLabel(): string
    {
        return $this->isGadis() ? 'Gadis Kampus' : 'Bujang Kampus';
    }

    public function genderShortLabel(): string
    {
        return $this->isGadis() ? 'Gadis' : 'Bujang';
    }

    public function displayName(): string
    {
        return $this->titleCase($this->name);
    }

    public function titleCase(?string $value): string
    {
        $value = trim(preg_replace('/\s+/u', ' ', (string) $value) ?? '');

        if ($value === '' || $value === '-') {
            return '';
        }

        return title_case($value);
    }

    public function instagramUrl(): ?string
    {
        return instagram_url($this->instagram);
    }

    public function scopeGenderCategory(Builder $query, string $category): Builder
    {
        return match ($category) {
            'gadis', 'female' => $query->whereIn('gender', ['gadis', 'female']),
            'bujang', 'male' => $query->whereIn('gender', ['bujang', 'male']),
            default => $query,
        };
    }

    public function batch(): BelongsTo
    {
        return $this->alumniBatch();
    }

    public function alumniBatch(): BelongsTo
    {
        return $this->belongsTo(AlumniBatch::class, 'alumni_batch_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
