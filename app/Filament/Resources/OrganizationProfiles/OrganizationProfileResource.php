<?php

namespace App\Filament\Resources\OrganizationProfiles;

use App\Filament\Resources\OrganizationProfiles\Pages\CreateOrganizationProfile;
use App\Filament\Resources\OrganizationProfiles\Pages\EditOrganizationProfile;
use App\Filament\Resources\OrganizationProfiles\Pages\ListOrganizationProfiles;
use App\Filament\Resources\OrganizationProfiles\Pages\ViewOrganizationProfile;
use App\Filament\Resources\OrganizationProfiles\Schemas\OrganizationProfileForm;
use App\Filament\Resources\OrganizationProfiles\Schemas\OrganizationProfileInfolist;
use App\Filament\Resources\OrganizationProfiles\Tables\OrganizationProfilesTable;
use App\Models\OrganizationProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class OrganizationProfileResource extends Resource
{
    protected static ?string $model = OrganizationProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Organisasi';

    protected static ?string $navigationLabel = 'Profil IBGK';

    protected static ?string $modelLabel = 'Profil IBGK';

    protected static ?string $pluralModelLabel = 'Profil IBGK';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrganizationProfileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrganizationProfileInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationProfilesTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return ! OrganizationProfile::query()->exists();
    }

    public static function canDelete(Model $record): bool
    {
        return false;
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
            'index' => ListOrganizationProfiles::route('/'),
            'create' => CreateOrganizationProfile::route('/create'),
            'view' => ViewOrganizationProfile::route('/{record}'),
            'edit' => EditOrganizationProfile::route('/{record}/edit'),
        ];
    }
}
