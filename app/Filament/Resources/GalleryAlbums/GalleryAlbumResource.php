<?php

namespace App\Filament\Resources\GalleryAlbums;

use App\Filament\Resources\GalleryAlbums\Pages\CreateGalleryAlbum;
use App\Filament\Resources\GalleryAlbums\Pages\EditGalleryAlbum;
use App\Filament\Resources\GalleryAlbums\Pages\ListGalleryAlbums;
use App\Filament\Resources\GalleryAlbums\Pages\ViewGalleryAlbum;
use App\Filament\Resources\GalleryAlbums\RelationManagers\PhotosRelationManager;
use App\Filament\Resources\GalleryAlbums\Schemas\GalleryAlbumForm;
use App\Filament\Resources\GalleryAlbums\Schemas\GalleryAlbumInfolist;
use App\Filament\Resources\GalleryAlbums\Tables\GalleryAlbumsTable;
use App\Models\GalleryAlbum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class GalleryAlbumResource extends Resource
{
    protected static ?string $model = GalleryAlbum::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Galeri';

    protected static ?string $modelLabel = 'Album Galeri';

    protected static ?string $pluralModelLabel = 'Galeri';

    protected static ?string $slug = 'galeri';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return GalleryAlbumForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GalleryAlbumInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GalleryAlbumsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('photos');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'location'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var GalleryAlbum $record */
        return [
            'Kategori' => $record->category,
            'Lokasi' => $record->location,
        ];
    }

    public static function getRelations(): array
    {
        return [
            PhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGalleryAlbums::route('/'),
            'create' => CreateGalleryAlbum::route('/create'),
            'view' => ViewGalleryAlbum::route('/{record}'),
            'edit' => EditGalleryAlbum::route('/{record}/edit'),
        ];
    }
}
