<?php

namespace App\Filament\Resources\OrganizationProfiles\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Support\SiteTheme;

class OrganizationProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Organisasi')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('logo')
                            ->label('Logo')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('name')
                            ->label('Nama Organisasi')
                            ->columnSpanFull(),
                        TextEntry::make('short_name')
                            ->label('Nama Singkat'),
                        TextEntry::make('founded_at')
                            ->label('Tanggal Berdiri')
                            ->formatStateUsing(
                                fn ($state) => $state
                                    ? $state->locale('id')->translatedFormat('d F Y')
                                    : '-'
                            ),
                        TextEntry::make('founder')
                            ->label('Pendiri'),
                        TextEntry::make('frontend_theme')
                            ->label('Tema Tampilan Situs')
                            ->formatStateUsing(
                                fn (?string $state) => SiteTheme::options()[SiteTheme::normalize($state)]
                            ),
                    ]),
                Section::make('Profil Organisasi')
                    ->schema([
                        TextEntry::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->columnSpanFull(),
                        TextEntry::make('description')
                            ->label('Tentang Organisasi')
                            ->html()
                            ->columnSpanFull(),
                    ]),
                Section::make('Visi & Misi')
                    ->schema([
                        TextEntry::make('vision')
                            ->label('Visi')
                            ->html()
                            ->columnSpanFull(),
                        TextEntry::make('mission')
                            ->label('Misi')
                            ->html()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
