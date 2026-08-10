<?php

namespace App\Filament\Resources\PartnershipInquiries\Schemas;

use App\Models\PartnershipInquiry;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnershipInquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Pengirim')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255)
                        ->disabled(fn (?PartnershipInquiry $record): bool => filled($record))
                        ->dehydrated(),
                    TextInput::make('organization')
                        ->label('Organisasi / Instansi')
                        ->maxLength(255)
                        ->disabled(fn (?PartnershipInquiry $record): bool => filled($record))
                        ->dehydrated(),
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->disabled(fn (?PartnershipInquiry $record): bool => filled($record))
                        ->dehydrated(),
                    TextInput::make('phone')
                        ->label('Nomor Telepon')
                        ->tel()
                        ->maxLength(255)
                        ->disabled(fn (?PartnershipInquiry $record): bool => filled($record))
                        ->dehydrated(),
                    TextInput::make('partnership_type')
                        ->label('Jenis Kerja Sama')
                        ->maxLength(255)
                        ->disabled(fn (?PartnershipInquiry $record): bool => filled($record))
                        ->dehydrated()
                        ->columnSpanFull(),
                ]),

            Section::make('Pesan')
                ->schema([
                    Textarea::make('message')
                        ->label('Pesan')
                        ->required()
                        ->rows(5)
                        ->disabled(fn (?PartnershipInquiry $record): bool => filled($record))
                        ->dehydrated()
                        ->columnSpanFull(),
                ]),

            Section::make('Tindak Lanjut')
                ->schema([
                    Select::make('status')
                        ->label('Status')
                        ->options(PartnershipInquiry::STATUSES)
                        ->required()
                        ->default(PartnershipInquiry::STATUS_NEW)
                        ->native(false),
                    Textarea::make('notes')
                        ->label('Catatan Internal')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
