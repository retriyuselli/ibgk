<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HonoraryMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'photo',
        'description',
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

    public function displayName(): string
    {
        return title_case($this->name);
    }

    public function displayTitle(): string
    {
        return title_case($this->title) ?: 'Anggota Kehormatan IBGK Sumsel';
    }
}
