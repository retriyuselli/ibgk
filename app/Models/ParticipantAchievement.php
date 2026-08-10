<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParticipantAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'title',
        'organizer',
        'level',
        'year',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }
}
