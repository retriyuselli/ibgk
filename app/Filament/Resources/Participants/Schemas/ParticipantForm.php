<?php

namespace App\Filament\Resources\Participants\Schemas;

use App\Models\Election;
use App\Models\ElectionStage;
use App\Models\Participant;
use App\Services\RegisterElectionParticipant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class ParticipantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pendaftaran')
                    ->columns(2)
                    ->schema([
                        Select::make('election_id')
                            ->label('Pemilihan')
                            ->relationship('election', 'name', fn ($query) => $query->orderByDesc('year'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, ?Participant $record): void {
                                self::syncIdentity($set, $get, $record);
                            }),
                        TextInput::make('registration_number')
                            ->label('Nomor Registrasi')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Kosongkan saat membuat peserta baru agar nomor dibuat otomatis.')
                            ->disabled(fn (?Participant $record): bool => filled($record))
                            ->dehydrated(),
                        Select::make('status')
                            ->label('Status')
                            ->options(self::statusOptions())
                            ->required()
                            ->default('registered')
                            ->native(false),
                        Select::make('current_stage_id')
                            ->label('Tahap Saat Ini')
                            ->options(fn (Get $get): array => ElectionStage::query()
                                ->where('election_id', $get('election_id'))
                                ->orderBy('sort_order')
                                ->pluck('name', 'id')
                                ->all())
                            ->searchable()
                            ->native(false)
                            ->helperText('Tahap yang sedang dijalani peserta.'),
                        Select::make('stage_result')
                            ->label('Hasil Tahap')
                            ->options(Participant::stageResultOptions())
                            ->required()
                            ->default('pending')
                            ->native(false)
                            ->helperText('Ditampilkan di Dashboard Peserta.'),
                        Textarea::make('stage_notes')
                            ->label('Catatan Panitia')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Opsional. Tampil di Dashboard, misalnya alasan atau arahan tahap berikutnya.'),
                        Toggle::make('is_public')
                            ->label('Tampilkan di Website')
                            ->default(false)
                            ->inline(false)
                            ->helperText('Profil peserta tampil di halaman pemilihan bila diaktifkan.'),
                    ]),

                Section::make('Data Diri')
                    ->columns(2)
                    ->schema([
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'male' => 'Bujang',
                                'female' => 'Gadis',
                            ])
                            ->required()
                            ->native(false),
                        Select::make('religion')
                            ->label('Agama')
                            ->options(Participant::religionOptions())
                            ->native(false),
                        TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, ?Participant $record): void {
                                self::syncIdentity($set, $get, $record);
                            }),
                        TextInput::make('nickname')
                            ->label('Nama Panggilan')
                            ->maxLength(255),
                        Hidden::make('slug')
                            ->dehydrated(),
                        TextInput::make('birth_place')
                            ->label('Tempat Lahir')
                            ->maxLength(255),
                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->maxDate(now()->subYears(15)),
                        TextInput::make('city')
                            ->label('Kota Asal')
                            ->maxLength(255),
                        self::photoUpload('photo', 'Foto Diri Close Up'),
                        self::photoUpload('photo_full_body', 'Foto Diri Full Body'),
                    ]),

                Section::make('Data Fisik & Kesehatan')
                    ->columns(2)
                    ->schema([
                        TextInput::make('height_cm')
                            ->label('Tinggi Badan (cm)')
                            ->numeric()
                            ->minValue(100)
                            ->maxValue(250),
                        TextInput::make('weight_kg')
                            ->label('Berat Badan (kg)')
                            ->numeric()
                            ->minValue(30)
                            ->maxValue(200)
                            ->step(0.1),
                        Textarea::make('medical_history')
                            ->label('Riwayat Penyakit')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Isi “Tidak ada” jika tidak memiliki riwayat penyakit.'),
                    ]),

                Section::make('Data Kampus')
                    ->columns(2)
                    ->schema([
                        TextInput::make('university')
                            ->label('Perguruan Tinggi')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('faculty')
                            ->label('Fakultas')
                            ->maxLength(255),
                        TextInput::make('study_program')
                            ->label('Program Studi')
                            ->maxLength(255),
                        TextInput::make('semester')
                            ->label('Semester')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(14),
                        TextInput::make('gpa')
                            ->label('IPK')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(4)
                            ->step(0.01),
                    ]),

                Section::make('Kontak & Sosmed')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->rules([
                                fn (Get $get, ?Participant $record) => Rule::unique('participants', 'email')
                                    ->where('election_id', $get('election_id'))
                                    ->ignore($record?->id),
                            ])
                            ->helperText('Email unik per pemilihan. Dipakai untuk akun Dashboard Peserta.'),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(30),
                        TextInput::make('emergency_phone')
                            ->label('Nomor Darurat')
                            ->tel()
                            ->maxLength(30),
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->maxLength(255)
                            ->placeholder('@username'),
                        TextInput::make('tiktok')
                            ->label('TikTok')
                            ->maxLength(255)
                            ->placeholder('@username'),
                        TextInput::make('motto')
                            ->label('Motto / Tagline')
                            ->maxLength(255),
                        Textarea::make('biography')
                            ->label('Profil Singkat')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Data Orang Tua')
                    ->columns(2)
                    ->schema([
                        TextInput::make('parent_name')
                            ->label('Nama Orang Tua')
                            ->maxLength(255),
                        TextInput::make('parent_occupation')
                            ->label('Pekerjaan Orang Tua')
                            ->maxLength(255),
                        Textarea::make('parent_address')
                            ->label('Alamat Orang Tua')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Prestasi & Minat')
                    ->schema([
                        Repeater::make('achievements')
                            ->relationship()
                            ->label('Prestasi')
                            ->defaultItems(0)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Prestasi')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('year')
                                    ->label('Tahun')
                                    ->numeric()
                                    ->minValue(1990)
                                    ->maxValue((int) now()->format('Y') + 1),
                                TextInput::make('level')
                                    ->label('Tingkat')
                                    ->maxLength(255),
                                TextInput::make('organizer')
                                    ->label('Penyelenggara')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Textarea::make('description')
                                    ->label('Keterangan')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                        Textarea::make('hobbies')
                            ->label('Hobi')
                            ->rows(3),
                        Textarea::make('talents')
                            ->label('Bakat Menarik')
                            ->rows(3),
                    ]),

                Section::make('Motivasi & Pendapat')
                    ->schema([
                        Textarea::make('motivation')
                            ->label('Motivasi Mengikuti PBGK')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('ibgk_opinion')
                            ->label('Pendapat Mengenai IBGKSS')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    /** @return array<string, string> */
    public static function statusOptions(): array
    {
        return [
            'registered' => 'Terdaftar',
            'active' => 'Aktif',
            'finalist' => 'Finalis',
            'winner' => 'Pemenang',
        ];
    }

    protected static function photoUpload(string $field, string $label): FileUpload
    {
        $maxDimension = (string) config('site.profile_photo_max_dimension', 1000);

        return FileUpload::make($field)
            ->label($label)
            ->image()
            ->directory('participants/photos')
            ->disk('public')
            ->visibility('public')
            ->imageEditor()
            ->maxSize((int) config('site.profile_photo_max_upload_kb', 10240))
            ->imageResizeMode('contain')
            ->imageResizeTargetWidth($maxDimension)
            ->imageResizeTargetHeight($maxDimension)
            ->imageResizeUpscale(false)
            ->helperText('Foto dikompres otomatis ke ukuran standar (sisi terpanjang 1000px).');
    }

    protected static function syncIdentity(Set $set, Get $get, ?Participant $record): void
    {
        $name = trim((string) $get('full_name'));

        if (blank($name)) {
            return;
        }

        $year = Election::query()->whereKey($get('election_id'))->value('year') ?? (int) now()->format('Y');

        $set(
            'slug',
            app(RegisterElectionParticipant::class)->uniqueParticipantSlug($name, (int) $year, $record?->id),
        );
    }

    /** @param  array<string, mixed>  $data */
    public static function applyIdentityToData(array $data, ?int $ignoreParticipantId = null): array
    {
        $election = Election::query()->find($data['election_id'] ?? null);
        $registrar = app(RegisterElectionParticipant::class);

        if (blank($data['registration_number'] ?? null) && $election) {
            $data['registration_number'] = $registrar->nextRegistrationNumber($election);
        }

        if (filled($data['full_name'] ?? null)) {
            $data['slug'] = $registrar->uniqueParticipantSlug(
                (string) $data['full_name'],
                (int) ($election?->year ?? now()->format('Y')),
                $ignoreParticipantId,
            );
        }

        return $data;
    }
}
