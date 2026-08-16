<?php

namespace App\Filament\Resources\HomepagePopups;

use App\Filament\Resources\HomepagePopups\Pages\CreateHomepagePopup;
use App\Filament\Resources\HomepagePopups\Pages\EditHomepagePopup;
use App\Filament\Resources\HomepagePopups\Pages\ListHomepagePopups;
use App\Filament\Resources\HomepagePopups\Pages\ViewHomepagePopup;
use App\Filament\Resources\HomepagePopups\Schemas\HomepagePopupForm;
use App\Filament\Resources\HomepagePopups\Schemas\HomepagePopupInfolist;
use App\Filament\Resources\HomepagePopups\Tables\HomepagePopupsTable;
use App\Models\HomepagePopup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class HomepagePopupResource extends Resource
{
    protected static ?string $model = HomepagePopup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Popup Beranda';

    protected static ?string $modelLabel = 'Popup Beranda';

    protected static ?string $pluralModelLabel = 'Popup Beranda';

    protected static ?string $slug = 'popup-beranda';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return HomepagePopupForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HomepagePopupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HomepagePopupsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHomepagePopups::route('/'),
            'create' => CreateHomepagePopup::route('/create'),
            'view' => ViewHomepagePopup::route('/{record}'),
            'edit' => EditHomepagePopup::route('/{record}/edit'),
        ];
    }
}
