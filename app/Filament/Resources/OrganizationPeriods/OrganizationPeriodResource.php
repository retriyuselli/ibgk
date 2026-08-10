<?php

namespace App\Filament\Resources\OrganizationPeriods;

use App\Filament\Resources\OrganizationPeriods\Pages\CreateOrganizationPeriod;
use App\Filament\Resources\OrganizationPeriods\Pages\EditOrganizationPeriod;
use App\Filament\Resources\OrganizationPeriods\Pages\ListOrganizationPeriods;
use App\Filament\Resources\OrganizationPeriods\Pages\ViewOrganizationPeriod;
use App\Filament\Resources\OrganizationPeriods\RelationManagers\MembersRelationManager;
use App\Filament\Resources\OrganizationPeriods\Schemas\OrganizationPeriodForm;
use App\Filament\Resources\OrganizationPeriods\Schemas\OrganizationPeriodInfolist;
use App\Filament\Resources\OrganizationPeriods\Tables\OrganizationPeriodsTable;
use App\Models\OrganizationPeriod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OrganizationPeriodResource extends Resource
{
    protected static ?string $model = OrganizationPeriod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Organisasi';

    protected static ?string $navigationLabel = 'Periode Kepengurusan';

    protected static ?string $modelLabel = 'Periode Kepengurusan';

    protected static ?string $pluralModelLabel = 'Periode Kepengurusan';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrganizationPeriodForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrganizationPeriodInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationPeriodsTable::configure($table);
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
            'index' => ListOrganizationPeriods::route('/'),
            'create' => CreateOrganizationPeriod::route('/create'),
            'view' => ViewOrganizationPeriod::route('/{record}'),
            'edit' => EditOrganizationPeriod::route('/{record}/edit'),
        ];
    }
}
