<?php

namespace App\Filament\Resources\ActivityCategories;

use App\Filament\Resources\ActivityCategories\Pages\CreateActivityCategory;
use App\Filament\Resources\ActivityCategories\Pages\EditActivityCategory;
use App\Filament\Resources\ActivityCategories\Pages\ListActivityCategories;
use App\Filament\Resources\ActivityCategories\Pages\ViewActivityCategory;
use App\Filament\Resources\ActivityCategories\Schemas\ActivityCategoryForm;
use App\Filament\Resources\ActivityCategories\Schemas\ActivityCategoryInfolist;
use App\Filament\Resources\ActivityCategories\Tables\ActivityCategoriesTable;
use App\Models\ActivityCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ActivityCategoryResource extends Resource
{
    protected static ?string $model = ActivityCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Kategori Kegiatan';

    protected static ?string $modelLabel = 'Kategori Kegiatan';

    protected static ?string $pluralModelLabel = 'Kategori Kegiatan';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ActivityCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ActivityCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivityCategoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityCategories::route('/'),
            'create' => CreateActivityCategory::route('/create'),
            'view' => ViewActivityCategory::route('/{record}'),
            'edit' => EditActivityCategory::route('/{record}/edit'),
        ];
    }
}
