<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use App\Models\ContactMessage;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Pengirim')->columns(2)->schema([
                TextEntry::make('name')->label('Nama'),
                TextEntry::make('email')->label('Email'),
                TextEntry::make('phone')->label('Nomor Telepon')->placeholder('-')->columnSpanFull(),
            ]),
            Section::make('Pesan')->schema([
                TextEntry::make('subject')->label('Subjek')->placeholder('-'),
                TextEntry::make('message')->label('Pesan')->columnSpanFull(),
            ]),
            Section::make('Status')->columns(2)->schema([
                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => ContactMessage::STATUSES[$state] ?? (string) $state)
                    ->color(fn (?string $state): string => match ($state) {
                        'new' => 'warning',
                        'read' => 'info',
                        'replied' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    }),
                TextEntry::make('created_at')->label('Tanggal Masuk')->dateTime('d M Y H:i'),
            ]),
        ]);
    }
}
