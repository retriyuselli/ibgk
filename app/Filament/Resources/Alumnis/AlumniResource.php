<?php

namespace App\Filament\Resources\Alumnis;

use App\Filament\Resources\Alumnis\Pages\CreateAlumni;
use App\Filament\Resources\Alumnis\Pages\EditAlumni;
use App\Filament\Resources\Alumnis\Pages\ListAlumnis;
use App\Filament\Resources\Alumnis\Pages\ViewAlumni;
use App\Filament\Resources\Alumnis\Schemas\AlumniForm;
use App\Filament\Resources\Alumnis\Schemas\AlumniInfolist;
use App\Filament\Resources\Alumnis\Tables\AlumnisTable;
use App\Models\Alumni;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class AlumniResource extends Resource
{
    protected static ?string $model = Alumni::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Alumni';

    protected static ?string $navigationLabel = 'Alumni';

    protected static ?string $modelLabel = 'Alumni';

    protected static ?string $pluralModelLabel = 'Alumni';

    protected static ?string $slug = 'alumni';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AlumniForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AlumniInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlumnisTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['batch', 'participant', 'organizationMembers.period', 'organizationMembers.position']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'university', 'profession', 'company'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Alumni $record */
        return [
            'Angkatan' => $record->batch?->name,
            'Perguruan Tinggi' => $record->university,
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAlumnis::route('/'),
            'create' => CreateAlumni::route('/create'),
            'view' => ViewAlumni::route('/{record}'),
            'edit' => EditAlumni::route('/{record}/edit'),
        ];
    }
}
