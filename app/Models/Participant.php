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
        'registration_number',
        'gender',
        'full_name',
        'slug',
        'photo',
        'birth_place',
        'birth_date',
        'university',
        'faculty',
        'study_program',
        'semester',
        'city',
        'email',
        'phone',
        'address',
        'motto',
        'biography',
        'instagram',
        'status',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'semester' => 'integer',
            'is_public' => 'boolean',
        ];
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(ParticipantAchievement::class);
    }

    public function alumni(): HasOne
    {
        return $this->hasOne(Alumni::class);
    }
}
