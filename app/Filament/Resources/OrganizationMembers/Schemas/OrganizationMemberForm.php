<?php

namespace App\Filament\Resources\OrganizationMembers\Schemas;

use App\Models\Alumni;
use App\Models\OrganizationPeriod;
use App\Models\OrganizationPosition;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class OrganizationMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kepengurusan')
                    ->columns(2)
                    ->schema([
                        Select::make('organization_period_id')
                            ->label('Periode Kepengurusan')
                            ->relationship('period', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(fn () => OrganizationPeriod::query()->where('is_active', true)->value('id')),
                        Select::make('organization_position_id')
                            ->label('Jabatan')
                            ->relationship(
                                name: 'position',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->orderBy('sort_order'),
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, mixed $state): void {
                                if (! self::positionRequiresDivision($state)) {
                                    $set('organization_division_id', null);
                                }
                            })
                            ->helperText('Ketua Bidang dan Anggota wajib memilih Bidang.'),
                        Select::make('organization_division_id')
                            ->label('Bidang')
                            ->relationship(
                                name: 'division',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->orderBy('sort_order'),
                            )
                            ->searchable()
                            ->preload()
                            ->visible(fn (Get $get): bool => self::positionRequiresDivision($get('organization_position_id')))
                            ->required(fn (Get $get): bool => self::positionRequiresDivision($get('organization_position_id')))
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Bidang')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Contoh: Pendidikan, Sosial, Seni & Budaya.')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get, ?string $state, ?string $old): void {
                                        $currentSlug = $get('slug');
                                        if (blank($currentSlug) || $currentSlug === Str::slug((string) $old)) {
                                            $set('slug', Str::slug((string) $state));
                                        }
                                    }),
                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                                Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true),
                            ])
                            ->helperText('Jika daftar masih kosong, klik tombol + di kanan field ini untuk menambah bidang.')
                            ->columnSpanFull(),
                        Select::make('anggota')
                            ->label('Anggota')
                            ->multiple()
                            ->relationship(
                                name: 'anggota',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->with('batch')->orderBy('name'),
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (Alumni $record): string => trim(
                                    $record->name.' — '.($record->batch?->name ?? 'Tanpa angkatan')
                                )
                            )
                            ->searchable()
                            ->preload()
                            ->visible(fn (Get $get): bool => self::positionIsDivisionLead($get('organization_position_id')))
                            ->dehydrated(fn (Get $get): bool => self::positionIsDivisionLead($get('organization_position_id')))
                            ->helperText('Pilih satu atau lebih anggota. Mereka akan tampil di bawah ketua bidang ini pada halaman kepengurusan.')
                            ->columnSpanFull(),
                        Select::make('alumni_id')
                            ->label('Profil Alumni')
                            ->relationship(
                                name: 'alumni',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->with('batch')->orderBy('name'),
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (Alumni $record): string => trim(
                                    $record->name.' — '.($record->batch?->name ?? 'Tanpa angkatan')
                                )
                            )
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Opsional. Hubungkan orang di jabatan ini ke profil alumni (foto, kampus, dan tautan halaman alumni).')
                            ->columnSpanFull(),
                    ]),

                Section::make('Data Pengurus')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        FileUpload::make('photo')
                            ->label('Foto')
                            ->image()
                            ->directory('organization-members')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->avatar()
                            ->columnSpanFull(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(255),
                        Textarea::make('bio')
                            ->label('Biografi Singkat')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Pengaturan')
                    ->columns(2)
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }

    private static function positionRequiresDivision(mixed $positionId): bool
    {
        if (blank($positionId)) {
            return false;
        }

        return (bool) OrganizationPosition::query()->find($positionId)?->requiresDivision();
    }

    private static function positionIsDivisionLead(mixed $positionId): bool
    {
        if (blank($positionId)) {
            return false;
        }

        return (bool) OrganizationPosition::query()->find($positionId)?->isDivisionLead();
    }
}
