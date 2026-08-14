<?php

namespace App\Filament\Resources\HonoraryMembers;

use App\Filament\Resources\HonoraryMembers\Pages\CreateHonoraryMember;
use App\Filament\Resources\HonoraryMembers\Pages\EditHonoraryMember;
use App\Filament\Resources\HonoraryMembers\Pages\ListHonoraryMembers;
use App\Filament\Resources\HonoraryMembers\Pages\ViewHonoraryMember;
use App\Filament\Resources\HonoraryMembers\Schemas\HonoraryMemberForm;
use App\Filament\Resources\HonoraryMembers\Schemas\HonoraryMemberInfolist;
use App\Filament\Resources\HonoraryMembers\Tables\HonoraryMembersTable;
use App\Models\HonoraryMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class HonoraryMemberResource extends Resource
{
    protected static ?string $model = HonoraryMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static string|UnitEnum|null $navigationGroup = 'Organisasi';

    protected static ?string $navigationLabel = 'Anggota Kehormatan';

    protected static ?string $modelLabel = 'Anggota Kehormatan';

    protected static ?string $pluralModelLabel = 'Anggota Kehormatan';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return HonoraryMemberForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HonoraryMemberInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HonoraryMembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHonoraryMembers::route('/'),
            'create' => CreateHonoraryMember::route('/create'),
            'view' => ViewHonoraryMember::route('/{record}'),
            'edit' => EditHonoraryMember::route('/{record}/edit'),
        ];
    }
}
