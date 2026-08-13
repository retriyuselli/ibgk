<?php

namespace App\Filament\Resources\Participants;

use App\Filament\Resources\Participants\Pages\CreateParticipant;
use App\Filament\Resources\Participants\Pages\EditParticipant;
use App\Filament\Resources\Participants\Pages\ListParticipants;
use App\Filament\Resources\Participants\Pages\ViewParticipant;
use App\Filament\Resources\Participants\Schemas\ParticipantForm;
use App\Filament\Resources\Participants\Schemas\ParticipantInfolist;
use App\Filament\Resources\Participants\Tables\ParticipantsTable;
use App\Models\Participant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Pemilihan BGK';

    protected static ?string $navigationLabel = 'Peserta';

    protected static ?string $modelLabel = 'Peserta';

    protected static ?string $pluralModelLabel = 'Peserta';

    protected static ?string $slug = 'peserta';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Schema $schema): Schema
    {
        return ParticipantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ParticipantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParticipantsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['election', 'alumni', 'achievements']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['full_name', 'registration_number', 'university', 'email'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Participant $record */
        return [
            'Nomor' => $record->registration_number,
            'Pemilihan' => $record->election?->name,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListParticipants::route('/'),
            'create' => CreateParticipant::route('/create'),
            'view' => ViewParticipant::route('/{record}'),
            'edit' => EditParticipant::route('/{record}/edit'),
        ];
    }
}
