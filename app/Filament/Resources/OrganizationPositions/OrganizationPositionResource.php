<?php

namespace App\Filament\Resources\OrganizationPositions;

use App\Filament\Resources\OrganizationPositions\Pages\CreateOrganizationPosition;
use App\Filament\Resources\OrganizationPositions\Pages\EditOrganizationPosition;
use App\Filament\Resources\OrganizationPositions\Pages\ListOrganizationPositions;
use App\Filament\Resources\OrganizationPositions\Pages\ViewOrganizationPosition;
use App\Filament\Resources\OrganizationPositions\Schemas\OrganizationPositionForm;
use App\Filament\Resources\OrganizationPositions\Schemas\OrganizationPositionInfolist;
use App\Filament\Resources\OrganizationPositions\Tables\OrganizationPositionsTable;
use App\Models\OrganizationPosition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class OrganizationPositionResource extends Resource
{
    protected static ?string $model = OrganizationPosition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|UnitEnum|null $navigationGroup = 'Organisasi';

    protected static ?string $navigationLabel = 'Jabatan';

    protected static ?string $modelLabel = 'Jabatan';

    protected static ?string $pluralModelLabel = 'Jabatan';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrganizationPositionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrganizationPositionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationPositionsTable::configure($table);
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrganizationPositions::route('/'),
            'create' => CreateOrganizationPosition::route('/create'),
            'view' => ViewOrganizationPosition::route('/{record}'),
            'edit' => EditOrganizationPosition::route('/{record}/edit'),
        ];
    }
}
