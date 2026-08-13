<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id',
        'user_id',
        'registration_number',
        'gender',
        'religion',
        'full_name',
        'nickname',
        'slug',
        'photo',
        'photo_full_body',
        'birth_place',
        'birth_date',
        'university',
        'faculty',
        'study_program',
        'semester',
        'gpa',
        'height_cm',
        'weight_kg',
        'medical_history',
        'city',
        'email',
        'phone',
        'emergency_phone',
        'address',
        'motto',
        'biography',
        'instagram',
        'tiktok',
        'hobbies',
        'talents',
        'parent_name',
        'parent_occupation',
        'parent_address',
        'motivation',
        'ibgk_opinion',
        'status',
        'current_stage_id',
        'stage_result',
        'stage_notes',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'semester' => 'integer',
            'gpa' => 'decimal:2',
            'height_cm' => 'integer',
            'weight_kg' => 'decimal:1',
            'is_public' => 'boolean',
        ];
    }

    /** @return array<string, string> */
    public static function religionOptions(): array
    {
        return [
            'islam' => 'Islam',
            'kristen_protestan' => 'Kristen Protestan',
            'kristen_katolik' => 'Kristen Katolik',
            'hindu' => 'Hindu',
            'buddha' => 'Buddha',
            'konghucu' => 'Konghucu',
        ];
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currentStage(): BelongsTo
    {
        return $this->belongsTo(ElectionStage::class, 'current_stage_id');
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(ParticipantAchievement::class);
    }

    public function alumni(): HasOne
    {
        return $this->hasOne(Alumni::class);
    }

    public function genderLabel(): string
    {
        return match ($this->gender) {
            'male' => 'Bujang',
            'female' => 'Gadis',
            default => (string) $this->gender,
        };
    }

    public function religionLabel(): string
    {
        return static::religionOptions()[$this->religion] ?? (string) ($this->religion ?: '-');
    }

    /** @return array<string, string> */
    public static function stageResultOptions(): array
    {
        return [
            'pending' => 'Menunggu pengumuman',
            'passed' => 'Lulus ke tahap selanjutnya',
            'failed' => 'Tidak lulus',
        ];
    }

    public function stageResultLabel(): string
    {
        return static::stageResultOptions()[$this->stage_result] ?? 'Menunggu pengumuman';
    }

    public function nextStage(): ?ElectionStage
    {
        $stages = $this->election?->stages
            ? $this->election->stages->sortBy('sort_order')->values()
            : collect();

        if ($stages->isEmpty()) {
            return null;
        }

        if (! $this->current_stage_id) {
            return $stages->first();
        }

        $currentOrder = (int) ($this->currentStage?->sort_order ?? 0);

        return $stages->first(fn (ElectionStage $stage): bool => $stage->sort_order > $currentOrder);
    }

    public function displayName(): string
    {
        return $this->full_name;
    }
}
