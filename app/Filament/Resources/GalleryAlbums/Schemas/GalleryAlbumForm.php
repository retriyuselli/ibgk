<?php

namespace App\Filament\Resources\GalleryAlbums\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class GalleryAlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Album')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Album')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get, ?string $state, ?string $old): void {
                            $currentSlug = $get('slug');
                            if (blank($currentSlug) || $currentSlug === Str::slug((string) $old)) {
                                $set('slug', Str::slug((string) $state));
                            }
                        })
                        ->columnSpanFull(),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull(),
                    Select::make('category')
                        ->label('Kategori')
                        ->options([
                            'Pemilihan BGK' => 'Pemilihan BGK',
                            'Kegiatan' => 'Kegiatan',
                            'Sosial' => 'Sosial',
                            'Budaya' => 'Budaya',
                            'Alumni' => 'Alumni',
                            'Internal' => 'Internal',
                            'Kemitraan' => 'Kemitraan',
                        ])
                        ->searchable()
                        ->nullable(),
                    DatePicker::make('event_date')
                        ->label('Tanggal Kegiatan')
                        ->native(false)
                        ->displayFormat('d F Y'),
                    TextInput::make('location')
                        ->label('Lokasi')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),

            Section::make('Deskripsi')->schema([
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),
            ])->collapsed(),

            Section::make('Cover Album')->schema([
                FileUpload::make('cover')
                    ->label('Cover')
                    ->image()
                    ->directory('gallery/covers')
                    ->disk('public')
                    ->visibility('public')
                    ->imageEditor()
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ]),

            Section::make('Publikasi')->columns(2)->schema([
                Toggle::make('is_featured')
                    ->label('Album Unggulan')
                    ->default(false)
                    ->inline(false),
                Toggle::make('is_published')
                    ->label('Dipublikasikan')
                    ->default(false)
                    ->inline(false),
            ]),
        ]);
    }
}
