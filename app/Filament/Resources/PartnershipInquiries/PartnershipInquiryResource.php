<?php

namespace App\Filament\Resources\PartnershipInquiries;

use App\Filament\Resources\PartnershipInquiries\Pages\CreatePartnershipInquiry;
use App\Filament\Resources\PartnershipInquiries\Pages\EditPartnershipInquiry;
use App\Filament\Resources\PartnershipInquiries\Pages\ListPartnershipInquiries;
use App\Filament\Resources\PartnershipInquiries\Pages\ViewPartnershipInquiry;
use App\Filament\Resources\PartnershipInquiries\Schemas\PartnershipInquiryForm;
use App\Filament\Resources\PartnershipInquiries\Schemas\PartnershipInquiryInfolist;
use App\Filament\Resources\PartnershipInquiries\Tables\PartnershipInquiriesTable;
use App\Models\PartnershipInquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PartnershipInquiryResource extends Resource
{
    protected static ?string $model = PartnershipInquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHandRaised;

    protected static string|UnitEnum|null $navigationGroup = 'Kemitraan';

    protected static ?string $navigationLabel = 'Pengajuan Kerja Sama';

    protected static ?string $modelLabel = 'Pengajuan Kerja Sama';

    protected static ?string $pluralModelLabel = 'Pengajuan Kerja Sama';

    protected static ?string $slug = 'pengajuan-kerja-sama';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()
            ->where('status', PartnershipInquiry::STATUS_NEW)
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return PartnershipInquiryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PartnershipInquiryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartnershipInquiriesTable::configure($table);
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartnershipInquiries::route('/'),
            'create' => CreatePartnershipInquiry::route('/create'),
            'view' => ViewPartnershipInquiry::route('/{record}'),
            'edit' => EditPartnershipInquiry::route('/{record}/edit'),
        ];
    }
}
