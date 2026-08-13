<?php

namespace App\Filament\Resources\Participants\Schemas;

use App\Models\Participant;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ParticipantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pendaftaran')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('photo')
                            ->label('Foto Close Up')
                            ->disk('public')
                            ->circular(),
                        ImageEntry::make('photo_full_body')
                            ->label('Foto Full Body')
                            ->disk('public'),
                        TextEntry::make('registration_number')
                            ->label('Nomor Registrasi')
                            ->copyable(),
                        TextEntry::make('election.name')
                            ->label('Pemilihan'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): string => ParticipantForm::statusOptions()[$state] ?? $state ?? '-'),
                        TextEntry::make('currentStage.name')
                            ->label('Tahap Saat Ini')
                            ->placeholder('-'),
                        TextEntry::make('stage_result')
                            ->label('Hasil Tahap')
                            ->badge()
                            ->formatStateUsing(fn (?string $state, Participant $record): string => $record->stageResultLabel())
                            ->color(fn (?string $state): string => match ($state) {
                                'passed' => 'success',
                                'failed' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('stage_notes')
                            ->label('Catatan Panitia')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        IconEntry::make('is_public')
                            ->label('Tampil di Website')
                            ->boolean(),
                    ]),

                Section::make('Data Diri')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('full_name')
                            ->label('Nama Lengkap'),
                        TextEntry::make('nickname')
                            ->label('Nama Panggilan')
                            ->placeholder('-'),
                        TextEntry::make('gender')
                            ->label('Jenis Kelamin')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                'male' => 'Bujang',
                                'female' => 'Gadis',
                                default => $state ?? '-',
                            }),
                        TextEntry::make('religion')
                            ->label('Agama')
                            ->formatStateUsing(fn (?string $state, Participant $record): string => $record->religionLabel())
                            ->placeholder('-'),
                        TextEntry::make('city')
                            ->label('Kota Asal')
                            ->placeholder('-'),
                        TextEntry::make('birth_place')
                            ->label('Tempat Lahir')
                            ->placeholder('-'),
                        TextEntry::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->date('d F Y')
                            ->placeholder('-'),
                        TextEntry::make('height_cm')
                            ->label('Tinggi Badan')
                            ->suffix(' cm')
                            ->placeholder('-'),
                        TextEntry::make('weight_kg')
                            ->label('Berat Badan')
                            ->suffix(' kg')
                            ->placeholder('-'),
                        TextEntry::make('medical_history')
                            ->label('Riwayat Penyakit')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Data Kampus')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('university')
                            ->label('Perguruan Tinggi')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('faculty')
                            ->label('Fakultas')
                            ->placeholder('-'),
                        TextEntry::make('study_program')
                            ->label('Program Studi')
                            ->placeholder('-'),
                        TextEntry::make('semester')
                            ->label('Semester')
                            ->placeholder('-'),
                        TextEntry::make('gpa')
                            ->label('IPK')
                            ->placeholder('-'),
                    ]),

                Section::make('Kontak & Sosmed')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('email')
                            ->label('Email')
                            ->placeholder('-'),
                        TextEntry::make('phone')
                            ->label('Nomor Telepon')
                            ->placeholder('-'),
                        TextEntry::make('emergency_phone')
                            ->label('Nomor Darurat')
                            ->placeholder('-'),
                        TextEntry::make('address')
                            ->label('Alamat')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('instagram')
                            ->label('Instagram')
                            ->placeholder('-'),
                        TextEntry::make('tiktok')
                            ->label('TikTok')
                            ->placeholder('-'),
                        TextEntry::make('motto')
                            ->label('Motto / Tagline')
                            ->placeholder('-'),
                        TextEntry::make('biography')
                            ->label('Profil Singkat')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Data Orang Tua')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('parent_name')
                            ->label('Nama Orang Tua')
                            ->placeholder('-'),
                        TextEntry::make('parent_occupation')
                            ->label('Pekerjaan Orang Tua')
                            ->placeholder('-'),
                        TextEntry::make('parent_address')
                            ->label('Alamat Orang Tua')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Prestasi & Minat')
                    ->schema([
                        RepeatableEntry::make('achievements')
                            ->label('Prestasi')
                            ->schema([
                                TextEntry::make('title')->label('Prestasi'),
                                TextEntry::make('year')->label('Tahun')->placeholder('-'),
                                TextEntry::make('level')->label('Tingkat')->placeholder('-'),
                            ])
                            ->columns(3),
                        TextEntry::make('hobbies')
                            ->label('Hobi')
                            ->placeholder('-'),
                        TextEntry::make('talents')
                            ->label('Bakat Menarik')
                            ->placeholder('-'),
                    ]),

                Section::make('Motivasi & Pendapat')
                    ->schema([
                        TextEntry::make('motivation')
                            ->label('Motivasi Mengikuti PBGK')
                            ->placeholder('-'),
                        TextEntry::make('ibgk_opinion')
                            ->label('Pendapat Mengenai IBGKSS')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
