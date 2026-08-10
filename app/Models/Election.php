<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'year',
        'theme',
        'short_description',
        'description',
        'registration_start',
        'registration_end',
        'grand_final_date',
        'location',
        'poster',
        'banner',
        'status',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'registration_start' => 'datetime',
            'registration_end' => 'datetime',
            'grand_final_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function stages(): HasMany
    {
        return $this->hasMany(ElectionStage::class);
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(ElectionRequirement::class);
    }

    public function benefits(): HasMany
    {
        return $this->hasMany(ElectionBenefit::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function alumniBatches(): HasMany
    {
        return $this->hasMany(AlumniBatch::class);
    }
}
