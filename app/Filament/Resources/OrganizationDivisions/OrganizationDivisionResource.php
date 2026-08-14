<?php

namespace App\Filament\Resources\OrganizationDivisions;

use App\Filament\Resources\OrganizationDivisions\Pages\CreateOrganizationDivision;
use App\Filament\Resources\OrganizationDivisions\Pages\EditOrganizationDivision;
use App\Filament\Resources\OrganizationDivisions\Pages\ListOrganizationDivisions;
use App\Filament\Resources\OrganizationDivisions\Pages\ViewOrganizationDivision;
use App\Filament\Resources\OrganizationDivisions\RelationManagers\MembersRelationManager;
use App\Filament\Resources\OrganizationDivisions\Schemas\OrganizationDivisionForm;
use App\Filament\Resources\OrganizationDivisions\Schemas\OrganizationDivisionInfolist;
use App\Filament\Resources\OrganizationDivisions\Tables\OrganizationDivisionsTable;
use App\Models\OrganizationDivision;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class OrganizationDivisionResource extends Resource
{
    protected static ?string $model = OrganizationDivision::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Organisasi';

    protected static ?string $navigationLabel = 'Bidang';

    protected static ?string $modelLabel = 'Bidang';

    protected static ?string $pluralModelLabel = 'Bidang';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrganizationDivisionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrganizationDivisionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationDivisionsTable::configure($table);
    }

    public static function canDelete(Model $record): bool
    {
        return $record->members()->doesntExist();
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrganizationDivisions::route('/'),
            'create' => CreateOrganizationDivision::route('/create'),
            'view' => ViewOrganizationDivision::route('/{record}'),
            'edit' => EditOrganizationDivision::route('/{record}/edit'),
        ];
    }
}
