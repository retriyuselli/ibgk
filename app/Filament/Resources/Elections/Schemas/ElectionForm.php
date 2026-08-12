<?php

namespace App\Filament\Resources\Elections\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ElectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Pemilihan')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Pemilihan')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get, ?string $state, ?string $old): void {
                            $currentSlug = $get('slug');
                            if (blank($currentSlug) || $currentSlug === Str::slug((string) $old)) {
                                $set('slug', Str::slug((string) $state));
                            }
                        })
                        ->helperText('Contoh: Pemilihan Bujang Gadis Kampus Sumatera Selatan 2026')
                        ->columnSpanFull(),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Contoh: pemilihan-bgk-2026'),
                    TextInput::make('year')
                        ->label('Tahun')
                        ->required()
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(2100)
                        ->default((int) now()->format('Y')),
                    TextInput::make('theme')
                        ->label('Tema')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    TextInput::make('location')
                        ->label('Lokasi')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'draft' => 'Draft',
                            'open' => 'Dibuka',
                            'closed' => 'Ditutup',
                            'finished' => 'Selesai',
                        ])
                        ->required()
                        ->default('draft'),
                    Toggle::make('is_active')
                        ->label('Aktif di website')
                        ->default(false)
                        ->inline(false),
                ]),

            Section::make('Jadwal')
                ->columns(2)
                ->schema([
                    DateTimePicker::make('registration_start')
                        ->label('Mulai Pendaftaran')
                        ->native(false)
                        ->seconds(false),
                    DateTimePicker::make('registration_end')
                        ->label('Akhir Pendaftaran')
                        ->native(false)
                        ->seconds(false)
                        ->after('registration_start'),
                    DatePicker::make('grand_final_date')
                        ->label('Tanggal Grand Final')
                        ->native(false)
                        ->displayFormat('d F Y'),
                ]),

            Section::make('Deskripsi')
                ->schema([
                    Textarea::make('short_description')
                        ->label('Ringkasan')
                        ->rows(3)
                        ->columnSpanFull(),
                    RichEditor::make('description')
                        ->label('Deskripsi Lengkap')
                        ->columnSpanFull(),
                ]),

            Section::make('Media')
                ->columns(2)
                ->schema([
                    FileUpload::make('poster')
                        ->label('Poster')
                        ->image()
                        ->disk('public')
                        ->directory('elections/poster')
                        ->visibility('public')
                        ->imageEditor()
                        ->openable()
                        ->downloadable(),
                    FileUpload::make('banner')
                        ->label('Banner')
                        ->image()
                        ->disk('public')
                        ->directory('elections/banner')
                        ->visibility('public')
                        ->imageEditor()
                        ->openable()
                        ->downloadable(),
                ]),

            Section::make('Tahapan')
                ->description('Urutan tahapan pemilihan (opsional).')
                ->schema([
                    Repeater::make('stages')
                        ->relationship()
                        ->label('Tahapan')
                        ->orderColumn('sort_order')
                        ->reorderable()
                        ->collapsible()
                        ->defaultItems(0)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Tahapan')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('description')
                                ->label('Deskripsi')
                                ->rows(2)
                                ->columnSpanFull(),
                            DatePicker::make('start_date')
                                ->label('Mulai')
                                ->native(false),
                            DatePicker::make('end_date')
                                ->label('Selesai')
                                ->native(false),
                        ])
                        ->columns(2)
                        ->columnSpanFull(),
                ]),

            Section::make('Persyaratan')
                ->schema([
                    Repeater::make('requirements')
                        ->relationship()
                        ->label('Persyaratan')
                        ->orderColumn('sort_order')
                        ->reorderable()
                        ->defaultItems(0)
                        ->simple(
                            TextInput::make('requirement')
                                ->label('Persyaratan')
                                ->required()
                                ->maxLength(500),
                        )
                        ->columnSpanFull(),
                ]),

            Section::make('Manfaat')
                ->schema([
                    Repeater::make('benefits')
                        ->relationship()
                        ->label('Manfaat')
                        ->orderColumn('sort_order')
                        ->reorderable()
                        ->collapsible()
                        ->defaultItems(0)
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('icon')
                                ->label('Ikon')
                                ->helperText('Contoh: trophy, users, sparkles')
                                ->maxLength(50),
                            Textarea::make('description')
                                ->label('Deskripsi')
                                ->rows(2)
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
