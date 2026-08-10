<?php

namespace App\Filament\Resources\GalleryAlbums\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Foto';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')
                ->label('Foto')
                ->image()
                ->directory('gallery/photos')
                ->disk('public')
                ->visibility('public')
                ->imageEditor()
                ->required()
                ->maxSize(5120)
                ->columnSpanFull(),
            TextInput::make('caption')
                ->label('Caption')
                ->maxLength(255)
                ->columnSpanFull(),
            TextInput::make('photographer')
                ->label('Fotografer')
                ->maxLength(255),
            TextInput::make('sort_order')
                ->label('Urutan')
                ->numeric()
                ->default(0)
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('caption')
            ->columns([
                ImageColumn::make('image')->label('Foto')->disk('public')->square(),
                TextColumn::make('caption')->label('Caption')->searchable()->placeholder('-'),
                TextColumn::make('photographer')->label('Fotografer')->placeholder('-'),
                TextColumn::make('sort_order')->label('Urutan')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                CreateAction::make()->label('Tambah Foto'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
