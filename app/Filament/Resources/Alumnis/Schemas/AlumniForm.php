<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use App\Models\Alumni;
use App\Models\AlumniBatch;
use App\Models\Participant;
use App\Services\PromoteParticipantToAlumni;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class AlumniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Keanggotaan')
                    ->columns(2)
                    ->schema([
                        Select::make('alumni_batch_id')
                            ->label('Keanggotaan')
                            ->relationship(
                                name: 'batch',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->orderByDesc('year'),
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, ?Alumni $record): void {
                                self::syncSlug($set, $get, $record);
                            }),
                        Select::make('participant_id')
                            ->label('Peserta PBGK')
                            ->relationship(
                                name: 'participant',
                                titleAttribute: 'full_name',
                                modifyQueryUsing: function (Builder $query, Get $get, ?Alumni $record): Builder {
                                    $query->with('election')
                                        ->where(function (Builder $builder) use ($record): void {
                                            $builder->whereDoesntHave('alumni');

                                            if ($record?->participant_id) {
                                                $builder->orWhere(
                                                    $builder->getModel()->getQualifiedKeyName(),
                                                    $record->participant_id,
                                                );
                                            }
                                        })
                                        ->orderBy('full_name');

                                    $batchId = $get('alumni_batch_id');

                                    if (filled($batchId)) {
                                        $electionId = AlumniBatch::query()->whereKey($batchId)->value('election_id');

                                        if (filled($electionId)) {
                                            $query->where('election_id', $electionId);
                                        }
                                    }

                                    return $query;
                                },
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (Participant $record): string => trim(sprintf(
                                    '%s - %s - %s',
                                    $record->full_name,
                                    $record->election?->name ?? 'Tanpa Pemilihan',
                                    $record->registration_number,
                                ))
                            )
                            ->searchable(['full_name', 'registration_number'])
                            ->nullable()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, mixed $state, ?Alumni $record): void {
                                if (blank($state)) {
                                    return;
                                }

                                $participant = Participant::query()->find($state);

                                if (! $participant) {
                                    return;
                                }

                                self::fillBlank($set, $get, 'gender', $participant->gender);
                                self::fillBlank($set, $get, 'name', $participant->full_name);
                                self::fillBlank($set, $get, 'photo', $participant->photo);
                                self::fillBlank($set, $get, 'university', $participant->university);
                                self::fillBlank($set, $get, 'faculty', $participant->faculty);
                                self::fillBlank($set, $get, 'study_program', $participant->study_program);
                                self::fillBlank($set, $get, 'city', $participant->city);
                                self::fillBlank($set, $get, 'bio', $participant->biography);
                                self::fillBlank($set, $get, 'instagram', $participant->instagram);
                                self::fillBlank($set, $get, 'email', $participant->email);
                                self::fillBlank($set, $get, 'phone', $participant->phone);

                                self::syncSlug($set, $get, $record);
                            })
                            ->helperText('Opsional. Gunakan untuk alumni yang berasal dari peserta PBGK di sistem.')
                            ->rules([
                                fn (?Alumni $record): \Illuminate\Validation\Rules\Unique => Rule::unique('alumni', 'participant_id')
                                    ->ignore($record?->id),
                            ])
                            ->columnSpanFull(),
                        Select::make('gender')
                            ->label('Kategori')
                            ->options([
                                'bujang' => 'Bujang',
                                'gadis' => 'Gadis',
                            ])
                            ->required()
                            ->native(false),
                        Toggle::make('is_public')
                            ->label('Tampilkan di Website')
                            ->default(false)
                            ->inline(false)
                            ->helperText('Profil dasar boleh tampil di website publik bila diaktifkan.'),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->inline(false),
                    ]),

                Section::make('Profil Alumni')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, ?Alumni $record): void {
                                self::syncSlug($set, $get, $record);
                            })
                            ->helperText('Slug URL dibuat otomatis dari nama dan tahun angkatan.')
                            ->columnSpanFull(),
                        Hidden::make('slug')
                            ->dehydrated()
                            ->required(),
                        FileUpload::make('photo')
                            ->label('Foto')
                            ->image()
                            ->directory('alumni/profiles')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize((int) config('site.profile_photo_max_upload_kb', 10240))
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth((string) config('site.profile_photo_max_dimension', 1000))
                            ->imageResizeTargetHeight((string) config('site.profile_photo_max_dimension', 1000))
                            ->imageResizeUpscale(false)
                            ->columnSpanFull(),
                    ]),

                Section::make('Pendidikan')
                    ->columns(2)
                    ->schema([
                        TextInput::make('university')
                            ->label('Perguruan Tinggi')
                            ->maxLength(255),
                        TextInput::make('faculty')
                            ->label('Fakultas')
                            ->maxLength(255),
                        TextInput::make('study_program')
                            ->label('Program Studi')
                            ->maxLength(255),
                        TextInput::make('graduation_year')
                            ->label('Tahun Lulus')
                            ->numeric()
                            ->minValue(1999)
                            ->maxValue(now()->year + 10),
                    ])
                    ->collapsed(),

                Section::make('Karier')
                    ->columns(2)
                    ->schema([
                        TextInput::make('profession')
                            ->label('Profesi')
                            ->maxLength(255),
                        TextInput::make('company')
                            ->label('Instansi / Perusahaan')
                            ->maxLength(255),
                        TextInput::make('city')
                            ->label('Kota Domisili')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Section::make('Profil Publik')
                    ->columns(2)
                    ->schema([
                        Textarea::make('bio')
                            ->label('Biografi')
                            ->rows(4)
                            ->columnSpanFull(),
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->maxLength(255)
                            ->helperText('Boleh username (@sheila), ID saja (sheila), atau URL lengkap.'),
                        TextInput::make('linkedin')
                            ->label('LinkedIn')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->collapsed(),

                Section::make('Data Kontak')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(255),
                    ])
                    ->description('Data kontak tidak otomatis ditampilkan pada website publik.')
                    ->collapsed(),
            ]);
    }

    protected static function fillBlank(Set $set, Get $get, string $field, mixed $value): void
    {
        if (blank($get($field)) && filled($value)) {
            $set($field, $value);
        }
    }

    protected static function syncSlug(Set $set, Get $get, ?Alumni $record): void
    {
        $name = trim((string) $get('name'));

        if (blank($name)) {
            return;
        }

        $year = AlumniBatch::query()->whereKey($get('alumni_batch_id'))->value('year');

        $set(
            'slug',
            app(PromoteParticipantToAlumni::class)->uniqueSlug($name, $year, $record?->id),
        );
    }

    /** @param  array<string, mixed>  $data */
    public static function applySlugToData(array $data, ?int $ignoreAlumniId = null): array
    {
        if (blank($data['name'] ?? null)) {
            return $data;
        }

        $year = AlumniBatch::query()->whereKey($data['alumni_batch_id'] ?? null)->value('year');
        $data['slug'] = app(PromoteParticipantToAlumni::class)->uniqueSlug(
            (string) $data['name'],
            $year,
            $ignoreAlumniId,
        );

        return $data;
    }
}
