<?php

namespace App\Filament\Resources\PartnerCategories\Schemas;

use App\Models\PartnerCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PartnerCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Kategori')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Kategori')
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
                    TextInput::make('sort_order')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0)
                        ->required(),
                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true)
                        ->inline(false),
                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            Section::make('Tampilan Showcase')
                ->description('Pengaturan tema warna dan label untuk halaman proposal kemitraan.')
                ->columns(2)
                ->schema([
                    Select::make('showcase_theme')
                        ->label('Tema Warna Showcase')
                        ->options(PartnerCategory::themeOptions())
                        ->default(PartnerCategory::THEME_DEFAULT)
                        ->required(),
                    TextInput::make('official_partner_label')
                        ->label('Label Official Partner')
                        ->placeholder('Official Media Partner')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    TextInput::make('default_cta_label')
                        ->label('Label Tombol CTA Default')
                        ->placeholder('Kunjungi Website Mitra')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
