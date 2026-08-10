<?php

namespace App\Filament\Resources\AlumniBatches;

use App\Filament\Resources\AlumniBatches\Pages\CreateAlumniBatch;
use App\Filament\Resources\AlumniBatches\Pages\EditAlumniBatch;
use App\Filament\Resources\AlumniBatches\Pages\ListAlumniBatches;
use App\Filament\Resources\AlumniBatches\Pages\ViewAlumniBatch;
use App\Filament\Resources\AlumniBatches\RelationManagers\AlumniRelationManager;
use App\Filament\Resources\AlumniBatches\Schemas\AlumniBatchForm;
use App\Filament\Resources\AlumniBatches\Schemas\AlumniBatchInfolist;
use App\Filament\Resources\AlumniBatches\Tables\AlumniBatchesTable;
use App\Models\AlumniBatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class AlumniBatchResource extends Resource
{
    protected static ?string $model = AlumniBatch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Alumni';

    protected static ?string $navigationLabel = 'Angkatan';

    protected static ?string $modelLabel = 'Angkatan';

    protected static ?string $pluralModelLabel = 'Angkatan';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AlumniBatchForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AlumniBatchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlumniBatchesTable::configure($table);
    }

    public static function canDelete(Model $record): bool
    {
        return $record->alumni()->doesntExist();
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            AlumniRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAlumniBatches::route('/'),
            'create' => CreateAlumniBatch::route('/create'),
            'view' => ViewAlumniBatch::route('/{record}'),
            'edit' => EditAlumniBatch::route('/{record}/edit'),
        ];
    }
}
