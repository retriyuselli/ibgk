<?php

namespace App\Filament\Resources\AlumniBatches\Schemas;

use App\Models\Election;
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

class AlumniBatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Angkatan')
                    ->columns(2)
                    ->schema([
                        Select::make('election_id')
                            ->label('Pemilihan BGK')
                            ->relationship(
                                name: 'election',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->orderByDesc('year'),
                            )
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->live()
                            ->visible(fn (Get $get): bool => ! in_array($get('category'), ['founders', 'honorary'], true))
                            ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                                if (blank($state)) {
                                    return;
                                }

                                $election = Election::query()->find($state);

                                if (! $election) {
                                    return;
                                }

                                if (blank($get('year'))) {
                                    $set('year', $election->year);
                                }

                                if (blank($get('name'))) {
                                    $set('name', "BGK Sumsel {$election->year}");
                                }

                                if (blank($get('slug')) && filled($get('name'))) {
                                    $set('slug', Str::slug((string) $get('name')));
                                }
                            })
                            ->columnSpanFull(),
                        TextInput::make('name')
                            ->label('Nama Angkatan')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: BGK Sumsel 2026')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state, ?string $old): void {
                                $currentSlug = $get('slug');
                                $shouldUpdate = blank($currentSlug) || $currentSlug === Str::slug((string) $old);

                                if ($shouldUpdate) {
                                    $set('slug', Str::slug((string) $state));
                                }
                            }),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'election' => 'Angkatan Pemilihan BGK',
                                'founders' => 'Pendiri',
                                'honorary' => 'Anggota Kehormatan',
                            ])
                            ->default('election')
                            ->required()
                            ->live(),
                        TextInput::make('year')
                            ->label('Tahun')
                            ->required()
                            ->numeric()
                            ->minValue(1999)
                            ->maxValue(now()->year + 10)
                            ->helperText(fn (Get $get): ?string => match ($get('category')) {
                                'founders' => 'Gunakan 1999 untuk pengurutan pendiri sebelum angkatan 2002.',
                                'honorary' => 'Gunakan 1998 untuk pengurutan anggota kehormatan setelah pendiri.',
                                default => null,
                            }),
                        TextInput::make('historical_member_count')
                            ->label('Jumlah Finalis Berdasarkan Arsip')
                            ->numeric()
                            ->minValue(0)
                            ->nullable()
                            ->helperText('Digunakan untuk data historis apabila seluruh nama alumni belum dimasukkan ke database.'),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->inline(false)
                            ->columnSpanFull(),
                    ]),

                Section::make('Deskripsi')
                    ->columns(1)
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi Angkatan')
                            ->rows(4)
                            ->columnSpanFull(),
                        FileUpload::make('photo')
                            ->label('Foto Angkatan')
                            ->image()
                            ->directory('alumni/batches')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(5120)
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),
            ]);
    }
}
