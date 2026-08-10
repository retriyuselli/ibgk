<?php

namespace App\Filament\Resources\PartnershipInquiries\Schemas;

use App\Models\PartnershipInquiry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnershipInquiryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Pengirim')->columns(2)->schema([
                TextEntry::make('name')->label('Nama'),
                TextEntry::make('organization')->label('Organisasi / Instansi')->placeholder('-'),
                TextEntry::make('email')->label('Email'),
                TextEntry::make('phone')->label('Nomor Telepon')->placeholder('-'),
                TextEntry::make('partnership_type')->label('Jenis Kerja Sama')->placeholder('-')->columnSpanFull(),
            ]),
            Section::make('Pesan')->schema([
                TextEntry::make('message')->label('Pesan')->columnSpanFull(),
            ]),
            Section::make('Tindak Lanjut')->columns(2)->schema([
                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => PartnershipInquiry::STATUSES[$state] ?? (string) $state)
                    ->color(fn (?string $state): string => match ($state) {
                        'new' => 'warning',
                        'contacted', 'follow_up' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'closed' => 'gray',
                        default => 'gray',
                    }),
                TextEntry::make('created_at')->label('Tanggal Masuk')->dateTime('d M Y H:i'),
                TextEntry::make('notes')->label('Catatan Internal')->placeholder('-')->columnSpanFull(),
            ]),
        ]);
    }
}
