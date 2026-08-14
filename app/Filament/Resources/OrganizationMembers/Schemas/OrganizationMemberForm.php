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
                            ->helperText('Anggota akan tampil di bawah Ketua Bidang yang sama.')
                            ->columnSpanFull(),
                        Select::make('alumni_id')
                            ->label('Alumni')
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
                            ->helperText('Opsional. Hubungkan pengurus ke data alumni jika tersedia.')
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
}
