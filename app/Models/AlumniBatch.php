<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlumniBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id',
        'name',
        'slug',
        'year',
        'description',
        'photo',
        'historical_member_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'historical_member_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function alumni(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }
}
