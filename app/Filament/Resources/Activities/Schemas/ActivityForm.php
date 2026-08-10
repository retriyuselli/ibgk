<?php

namespace App\Filament\Resources\Activities\Schemas;

use App\Models\Activity;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Kegiatan')
                ->columns(2)
                ->schema([
                    Select::make('activity_category_id')
                        ->label('Kategori Kegiatan')
                        ->relationship(
                            name: 'category',
                            titleAttribute: 'name',
                            modifyQueryUsing: function (Builder $query, ?Activity $record): Builder {
                                return $query
                                    ->where(function (Builder $builder) use ($record): void {
                                        $builder->where('is_active', true);

                                        if ($record?->activity_category_id) {
                                            $builder->orWhere(
                                                $builder->getModel()->getQualifiedKeyName(),
                                                $record->activity_category_id,
                                            );
                                        }
                                    })
                                    ->orderBy('sort_order');
                            },
                        )
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('title')
                        ->label('Judul Kegiatan')
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
                    DatePicker::make('activity_date')
                        ->label('Tanggal Mulai')
                        ->native(false)
                        ->displayFormat('d F Y'),
                    DatePicker::make('end_date')
                        ->label('Tanggal Selesai')
                        ->native(false)
                        ->displayFormat('d F Y')
                        ->gte('activity_date')
                        ->validationMessages([
                            'gte' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
                        ]),
                    TextInput::make('location')
                        ->label('Lokasi')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),

            Section::make('Konten')
                ->schema([
                    Textarea::make('excerpt')
                        ->label('Ringkasan')
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),
                    RichEditor::make('content')
                        ->label('Isi Kegiatan')
                        ->columnSpanFull(),
                ]),

            Section::make('Media')
                ->columns(2)
                ->schema([
                    FileUpload::make('thumbnail')
                        ->label('Thumbnail')
                        ->image()
                        ->directory('activities/thumbnails')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(5120),
                    FileUpload::make('banner')
                        ->label('Banner')
                        ->image()
                        ->directory('activities/banners')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(5120),
                ])
                ->collapsed(),

            Section::make('Publikasi')
                ->columns(2)
                ->schema([
                    Toggle::make('is_featured')
                        ->label('Kegiatan Unggulan')
                        ->default(false)
                        ->inline(false),
                    Toggle::make('is_published')
                        ->label('Dipublikasikan')
                        ->default(false)
                        ->inline(false),
                    DateTimePicker::make('published_at')
                        ->label('Tanggal Publikasi')
                        ->native(false)
                        ->seconds(false)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
