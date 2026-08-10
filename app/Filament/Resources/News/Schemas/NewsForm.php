<?php

namespace App\Filament\Resources\News\Schemas;

use App\Models\News;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Berita')
                ->columns(2)
                ->schema([
                    Select::make('news_category_id')
                        ->label('Kategori')
                        ->relationship(
                            name: 'category',
                            titleAttribute: 'name',
                            modifyQueryUsing: function (Builder $query, ?News $record): Builder {
                                return $query
                                    ->where(function (Builder $builder) use ($record): void {
                                        $builder->where('is_active', true);

                                        if ($record?->news_category_id) {
                                            $builder->orWhere(
                                                $builder->getModel()->getQualifiedKeyName(),
                                                $record->news_category_id,
                                            );
                                        }
                                    })
                                    ->orderBy('sort_order');
                            },
                        )
                        ->searchable()
                        ->preload()
                        ->nullable(),
                    Select::make('user_id')
                        ->label('Penulis')
                        ->relationship('author', 'name')
                        ->searchable()
                        ->preload()
                        ->default(fn () => Auth::id())
                        ->nullable(),
                    TextInput::make('title')
                        ->label('Judul Berita')
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
                    TextInput::make('location')
                        ->label('Lokasi')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),

            Section::make('Konten')->schema([
                Textarea::make('excerpt')
                    ->label('Ringkasan')
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->label('Isi Berita')
                    ->columnSpanFull(),
            ]),

            Section::make('Media')->schema([
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->directory('news')
                    ->disk('public')
                    ->visibility('public')
                    ->imageEditor()
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ])->collapsed(),

            Section::make('Publikasi')->columns(2)->schema([
                Toggle::make('is_featured')
                    ->label('Berita Utama')
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
