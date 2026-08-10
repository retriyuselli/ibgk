<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use App\Models\ContactMessage;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Pengirim')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255)
                        ->disabled(fn (?ContactMessage $record): bool => filled($record))
                        ->dehydrated(),
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->disabled(fn (?ContactMessage $record): bool => filled($record))
                        ->dehydrated(),
                    TextInput::make('phone')
                        ->label('Nomor Telepon')
                        ->tel()
                        ->maxLength(255)
                        ->disabled(fn (?ContactMessage $record): bool => filled($record))
                        ->dehydrated()
                        ->columnSpanFull(),
                ]),

            Section::make('Pesan')
                ->schema([
                    TextInput::make('subject')
                        ->label('Subjek')
                        ->maxLength(255)
                        ->disabled(fn (?ContactMessage $record): bool => filled($record))
                        ->dehydrated(),
                    Textarea::make('message')
                        ->label('Pesan')
                        ->required()
                        ->rows(5)
                        ->disabled(fn (?ContactMessage $record): bool => filled($record))
                        ->dehydrated()
                        ->columnSpanFull(),
                ]),

            Section::make('Status')
                ->schema([
                    Select::make('status')
                        ->label('Status')
                        ->options(ContactMessage::STATUSES)
                        ->required()
                        ->default(ContactMessage::STATUS_NEW)
                        ->native(false),
                ]),
        ]);
    }
}
