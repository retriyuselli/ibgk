<?php

namespace App\Filament\Resources\Partners\Schemas;

use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Services\PartnerShowcasePresets;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Mitra')
                ->columns(2)
                ->schema([
                    Select::make('partner_category_id')
                        ->label('Kategori Mitra')
                        ->relationship(
                            name: 'category',
                            titleAttribute: 'name',
                            modifyQueryUsing: function (Builder $query, ?Partner $record): Builder {
                                return $query
                                    ->where(function (Builder $builder) use ($record): void {
                                        $builder->where('is_active', true);

                                        if ($record?->partner_category_id) {
                                            $builder->orWhere(
                                                $builder->getModel()->getQualifiedKeyName(),
                                                $record->partner_category_id,
                                            );
                                        }
                                    })
                                    ->orderBy('sort_order')
                                    ->orderBy('name');
                            },
                        )
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->live()
                        ->helperText('Pilih kategori untuk tema warna dan template proposal showcase.')
                        ->afterStateUpdated(function (Set $set, Get $get, ?string $state): void {
                            if (blank($state)) {
                                return;
                            }

                            $category = PartnerCategory::query()->find($state);

                            if (! $category) {
                                return;
                            }

                            if (filled($category->default_cta_label)) {
                                $set('external_cta_label', $category->default_cta_label);
                            }

                            if (filled($get('showcase_intro'))) {
                                return;
                            }

                            self::applyCategoryPreset($set, $get, $category);
                        })
                        ->columnSpanFull(),
                    TextInput::make('name')
                        ->label('Nama Mitra')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get, ?string $state, ?string $old): void {
                            $currentSlug = $get('slug');
                            if (blank($currentSlug) || $currentSlug === Str::slug((string) $old)) {
                                $set('slug', Str::slug((string) $state));
                            }
                        }),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('website')
                        ->label('Website')
                        ->url()
                        ->maxLength(255)
                        ->nullable()
                        ->columnSpanFull(),
                ]),

            Section::make('Profil Mitra')
                ->schema([
                    FileUpload::make('logo')
                        ->label('Logo')
                        ->image()
                        ->directory('partners/logos')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(5120)
                        ->columnSpanFull(),
                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Section::make('Pengaturan')
                ->columns(3)
                ->schema([
                    TextInput::make('sort_order')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0)
                        ->required(),
                    Toggle::make('is_featured')
                        ->label('Mitra Unggulan')
                        ->default(false)
                        ->inline(false),
                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true)
                        ->inline(false),
                ]),

            Section::make('Halaman Showcase Mitra')
                ->description('Proposal deck digital per mitra. Platinum = lengkap, Gold = ringkas (max 6 program). Silver/Bronze = logo saja di halaman kemitraan.')
                ->columns(2)
                ->schema([
                    Select::make('tier')
                        ->label('Tier Kemitraan')
                        ->options([
                            Partner::TIER_PLATINUM => 'Platinum Main Partner (showcase lengkap)',
                            Partner::TIER_GOLD => 'Gold Partner (showcase ringkas)',
                            Partner::TIER_SILVER => 'Silver Partner (tanpa showcase)',
                            Partner::TIER_BRONZE => 'Bronze Partner (tanpa showcase)',
                        ])
                        ->nullable()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, ?string $state): void {
                            if (in_array($state, [Partner::TIER_SILVER, Partner::TIER_BRONZE], true)) {
                                $set('has_showcase_page', false);
                                $set('is_main_sponsor', false);
                            }
                        }),
                    TextInput::make('showcase_year')
                        ->label('Tahun Kolaborasi')
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(now()->year + 5)
                        ->nullable(),
                    Toggle::make('is_main_sponsor')
                        ->label('Sponsor Utama')
                        ->default(false)
                        ->inline(false)
                        ->helperText('Mitra ini tampil di bagian Sponsor Utama halaman kemitraan. Bisa lebih dari satu; urutan mengikuti field Urutan.'),
                    Toggle::make('has_showcase_page')
                        ->label('Punya Halaman Showcase')
                        ->default(false)
                        ->inline(false)
                        ->helperText('Hanya tersedia untuk tier Platinum/Gold atau Sponsor Utama.'),
                    TextInput::make('tagline')
                        ->label('Tagline')
                        ->maxLength(255)
                        ->nullable()
                        ->columnSpanFull(),
                    Textarea::make('showcase_intro')
                        ->label('Ringkasan Kolaborasi')
                        ->rows(4)
                        ->columnSpanFull(),
                    TextInput::make('showcase_official_title')
                        ->label('Judul Official Partner')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Textarea::make('showcase_official_subtext')
                        ->label('Subteks Official Partner')
                        ->rows(2)
                        ->columnSpanFull(),
                    Textarea::make('showcase_program_quote')
                        ->label('Kutipan Program Kolaborasi')
                        ->rows(2)
                        ->columnSpanFull(),
                    TextInput::make('showcase_partner_tagline')
                        ->label('Tagline Mitra')
                        ->placeholder('Mitra Strategis Generasi Muda Sumatera Selatan')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Textarea::make('showcase_footer_quote')
                        ->label('Kutipan Penutup')
                        ->rows(3)
                        ->columnSpanFull(),
                    TextInput::make('showcase_social_handle')
                        ->label('Handle Media Sosial')
                        ->placeholder('@mitraofficial')
                        ->maxLength(255),
                    Textarea::make('showcase_privacy_note')
                        ->label('Catatan Privasi Data')
                        ->rows(3)
                        ->columnSpanFull(),
                    FileUpload::make('hero_image')
                        ->label('Gambar Hero Showcase')
                        ->image()
                        ->directory('partners/hero')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(5120)
                        ->columnSpanFull(),
                    TextInput::make('external_cta_label')
                        ->label('Label Tombol Website')
                        ->placeholder('Kunjungi Website Mitra')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Hidden::make('showcase_strategic_values'),
                    Hidden::make('showcase_programs'),
                    Hidden::make('showcase_benefits'),
                    Hidden::make('showcase_kpis'),
                    Hidden::make('showcase_targets'),
                    Hidden::make('showcase_timeline'),
                    Hidden::make('showcase_activations'),
                ])
                ->collapsed(),
        ]);
    }

    public static function applyCategoryPreset(Set $set, Get $get, PartnerCategory $category): void
    {
        $preset = PartnerShowcasePresets::forCategory(
            $category->slug,
            $get('name'),
            (int) ($get('showcase_year') ?: now()->year),
        );

        foreach ($preset as $field => $value) {
            $set($field, $value);
        }
    }
}
