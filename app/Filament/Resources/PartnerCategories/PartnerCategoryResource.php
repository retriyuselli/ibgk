<?php

namespace App\Filament\Resources\PartnerCategories;

use App\Filament\Resources\PartnerCategories\Pages\CreatePartnerCategory;
use App\Filament\Resources\PartnerCategories\Pages\EditPartnerCategory;
use App\Filament\Resources\PartnerCategories\Pages\ListPartnerCategories;
use App\Filament\Resources\PartnerCategories\Pages\ViewPartnerCategory;
use App\Filament\Resources\PartnerCategories\Schemas\PartnerCategoryForm;
use App\Filament\Resources\PartnerCategories\Schemas\PartnerCategoryInfolist;
use App\Filament\Resources\PartnerCategories\Tables\PartnerCategoriesTable;
use App\Models\PartnerCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PartnerCategoryResource extends Resource
{
    protected static ?string $model = PartnerCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Kemitraan';

    protected static ?string $navigationLabel = 'Kategori Mitra';

    protected static ?string $modelLabel = 'Kategori Mitra';

    protected static ?string $pluralModelLabel = 'Kategori Mitra';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PartnerCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PartnerCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartnerCategoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartnerCategories::route('/'),
            'create' => CreatePartnerCategory::route('/create'),
            'view' => ViewPartnerCategory::route('/{record}'),
            'edit' => EditPartnerCategory::route('/{record}/edit'),
        ];
    }
}
