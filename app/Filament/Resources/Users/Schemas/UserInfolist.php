<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Akun Pengguna')
                ->columns(2)
                ->schema([
                    TextEntry::make('name')
                        ->label('Nama'),
                    TextEntry::make('email')
                        ->label('Email')
                        ->copyable(),
                    TextEntry::make('roles.name')
                        ->label('Role')
                        ->badge()
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('email_verified_at')
                        ->label('Email Terverifikasi')
                        ->dateTime('d M Y H:i')
                        ->placeholder('Belum terverifikasi'),
                    TextEntry::make('created_at')
                        ->label('Dibuat')
                        ->dateTime('d M Y H:i'),
                    TextEntry::make('updated_at')
                        ->label('Diperbarui')
                        ->since(),
                ]),
        ]);
    }
}
