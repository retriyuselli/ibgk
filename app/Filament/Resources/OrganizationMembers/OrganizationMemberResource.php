<?php

namespace App\Filament\Resources\OrganizationMembers;

use App\Filament\Resources\OrganizationMembers\Pages\CreateOrganizationMember;
use App\Filament\Resources\OrganizationMembers\Pages\EditOrganizationMember;
use App\Filament\Resources\OrganizationMembers\Pages\ListOrganizationMembers;
use App\Filament\Resources\OrganizationMembers\Pages\ViewOrganizationMember;
use App\Filament\Resources\OrganizationMembers\Schemas\OrganizationMemberForm;
use App\Filament\Resources\OrganizationMembers\Schemas\OrganizationMemberInfolist;
use App\Filament\Resources\OrganizationMembers\Tables\OrganizationMembersTable;
use App\Models\OrganizationMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class OrganizationMemberResource extends Resource
{
    protected static ?string $model = OrganizationMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|UnitEnum|null $navigationGroup = 'Organisasi';

    protected static ?string $navigationLabel = 'Pengurus';

    protected static ?string $modelLabel = 'Pengurus';

    protected static ?string $pluralModelLabel = 'Pengurus';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrganizationMemberForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrganizationMemberInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationMembersTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['period', 'position', 'alumni']);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrganizationMembers::route('/'),
            'create' => CreateOrganizationMember::route('/create'),
            'view' => ViewOrganizationMember::route('/{record}'),
            'edit' => EditOrganizationMember::route('/{record}/edit'),
        ];
    }
}
