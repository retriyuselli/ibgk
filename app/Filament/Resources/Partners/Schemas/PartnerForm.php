<?php

namespace App\Filament\Resources\Partners\Schemas;

use App\Models\Partner;
use Filament\Forms\Components\FileUpload;
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
        ]);
    }
}
