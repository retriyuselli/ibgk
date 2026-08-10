<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'founded_at',
        'founder',
        'short_description',
        'description',
        'vision',
        'mission',
        'logo',
        'address',
        'phone',
        'email',
        'website',
        'instagram',
        'tiktok',
        'youtube',
        'facebook',
    ];

    protected function casts(): array
    {
        return [
            'founded_at' => 'date',
        ];
    }
}
