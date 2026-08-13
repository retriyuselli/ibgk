<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartnerCategory extends Model
{
    use HasFactory;

    public const THEME_BANKING = 'banking';

    public const THEME_MEDIA = 'media';

    public const THEME_RETAIL = 'retail';

    public const THEME_TELECOM = 'telecom';

    public const THEME_GOVERNMENT = 'government';

    public const THEME_TOURISM = 'tourism';

    public const THEME_DEFAULT = 'default';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'showcase_theme',
        'official_partner_label',
        'default_cta_label',
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

    /** @return array<string, string> */
    public static function themeOptions(): array
    {
        return [
            self::THEME_BANKING => 'Perbankan (hijau)',
            self::THEME_MEDIA => 'Media (biru)',
            self::THEME_RETAIL => 'Retail / Corporate (oranye)',
            self::THEME_TELECOM => 'Telekomunikasi (ungu)',
            self::THEME_GOVERNMENT => 'Pemerintah / BUMN (navy)',
            self::THEME_TOURISM => 'Pariwisata / Hotel (teal)',
            self::THEME_DEFAULT => 'Default IBGK (navy)',
        ];
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }

    public function iconName(): string
    {
        return match ($this->slug) {
            'pemerintah' => 'shield',
            'perguruan-tinggi' => 'campus',
            'perbankan' => 'card',
            'bumn' => 'building',
            'corporate' => 'spark',
            'media' => 'megaphone',
            'hotel' => 'map',
            'community' => 'users',
            default => 'handshake',
        };
    }

    /** @return array<string, string> */
    public static function partnerNames(): array
    {
        return [
            'pemerintah' => 'Pemerintah',
            'perguruan-tinggi' => 'Universitas',
            'perbankan' => 'Perbankan',
            'bumn' => 'BUMN',
            'corporate' => 'Corporate',
            'media' => 'Media',
            'hotel' => 'Hotel',
            'community' => 'Community',
        ];
    }
}
