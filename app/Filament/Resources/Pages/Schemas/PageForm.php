<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Halaman')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul')
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
                    Textarea::make('excerpt')
                        ->label('Ringkasan')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Section::make('Konten')
                ->schema([
                    RichEditor::make('content')
                        ->label('Konten')
                        ->columnSpanFull(),
                ]),

            Section::make('Media')
                ->schema([
                    FileUpload::make('banner')
                        ->label('Banner')
                        ->image()
                        ->directory('pages/banners')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(5120)
                        ->columnSpanFull(),
                ])
                ->collapsed(),

            Section::make('SEO')
                ->schema([
                    TextInput::make('meta_title')
                        ->label('SEO Title')
                        ->maxLength(255)
                        ->helperText('Digunakan untuk hasil pencarian Google dan social preview.'),
                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->rows(3)
                        ->helperText('Digunakan untuk hasil pencarian Google dan social preview.')
                        ->columnSpanFull(),
                ])
                ->collapsed(),

            Section::make('Publikasi')
                ->columns(2)
                ->schema([
                    Toggle::make('is_published')
                        ->label('Dipublikasikan')
                        ->default(false)
                        ->inline(false),
                    DateTimePicker::make('published_at')
                        ->label('Tanggal Publikasi')
                        ->native(false)
                        ->seconds(false),
                ]),
        ]);
    }
}
