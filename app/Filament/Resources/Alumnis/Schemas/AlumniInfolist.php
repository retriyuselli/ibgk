<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlumniInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil Alumni')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('photo')
                            ->label('Foto')
                            ->disk('public')
                            ->circular()
                            ->columnSpanFull(),
                        TextEntry::make('name')
                            ->label('Nama Lengkap')
                            ->columnSpanFull(),
                        TextEntry::make('batch.name')
                            ->label('Angkatan'),
                        TextEntry::make('gender')
                            ->label('Kategori')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'bujang' => 'Bujang',
                                'gadis' => 'Gadis',
                                default => $state,
                            }),
                        TextEntry::make('participant.full_name')
                            ->label('Peserta PBGK')
                            ->placeholder('-'),
                        TextEntry::make('university')
                            ->label('Perguruan Tinggi')
                            ->placeholder('-'),
                        TextEntry::make('faculty')
                            ->label('Fakultas')
                            ->placeholder('-'),
                        TextEntry::make('study_program')
                            ->label('Program Studi')
                            ->placeholder('-'),
                        TextEntry::make('profession')
                            ->label('Profesi')
                            ->placeholder('-'),
                        TextEntry::make('company')
                            ->label('Instansi / Perusahaan')
                            ->placeholder('-'),
                        TextEntry::make('city')
                            ->label('Kota Domisili')
                            ->placeholder('-'),
                        TextEntry::make('bio')
                            ->label('Biografi')
                            ->columnSpanFull()
                            ->placeholder('-'),
                        IconEntry::make('is_public')
                            ->label('Tampil di Website')
                            ->boolean(),
                        IconEntry::make('is_active')
                            ->label('Aktif')
                            ->boolean(),
                        TextEntry::make('profileFormStatusLabel')
                            ->label('Status Formulir')
                            ->state(fn ($record) => $record->profileFormStatusLabel()),
                        TextEntry::make('profile_submitted_at')
                            ->label('Diisi pada')
                            ->dateTime('d M Y H:i')
                            ->placeholder('-'),
                        TextEntry::make('profile_token_expires_at')
                            ->label('Link berlaku hingga')
                            ->dateTime('d M Y H:i')
                            ->placeholder('-'),
                    ]),

                Section::make('Riwayat Jabatan IBGK')
                    ->schema([
                        RepeatableEntry::make('organizationMembers')
                            ->label('')
                            ->schema([
                                TextEntry::make('period.name')
                                    ->label('Periode'),
                                TextEntry::make('position.name')
                                    ->label('Jabatan'),
                            ])
                            ->columns(2)
                            ->placeholder('Belum ada riwayat jabatan IBGK.'),
                    ])
                    ->collapsed(),

                Section::make('Data Kontak (Privat)')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('email')
                            ->label('Email')
                            ->placeholder('-'),
                        TextEntry::make('phone')
                            ->label('Nomor Telepon')
                            ->placeholder('-'),
                    ])
                    ->description('Tidak ditampilkan otomatis di website publik.')
                    ->collapsed(),
            ]);
    }
}
