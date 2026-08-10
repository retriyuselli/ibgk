<?php

namespace App\Filament\Resources\OrganizationProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganizationProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Organisasi')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Organisasi')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('short_name')
                            ->label('Nama Singkat')
                            ->maxLength(255),
                        DatePicker::make('founded_at')
                            ->label('Tanggal Berdiri')
                            ->native(false)
                            ->displayFormat('d F Y'),
                        TextInput::make('founder')
                            ->label('Pendiri')
                            ->maxLength(255),
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('organization')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),

                Section::make('Profil Organisasi')
                    ->columns(1)
                    ->schema([
                        Textarea::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->label('Tentang Organisasi')
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Section::make('Visi & Misi')
                    ->columns(1)
                    ->schema([
                        RichEditor::make('vision')
                            ->label('Visi')
                            ->columnSpanFull(),
                        RichEditor::make('mission')
                            ->label('Misi')
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Section::make('Kontak')
                    ->columns(2)
                    ->schema([
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Section::make('Media Sosial')
                    ->columns(2)
                    ->schema([
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('tiktok')
                            ->label('TikTok')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('youtube')
                            ->label('YouTube')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->collapsed(),
            ]);
    }
}
