<?php

namespace App\Filament\Resources\HonoraryMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HonoraryMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Anggota Kehormatan')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('title')
                            ->label('Gelar')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        FileUpload::make('photo')
                            ->label('Foto')
                            ->image()
                            ->directory('honorary-members')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Keterangan')
                            ->rows(4)
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->label('Urutan')
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
}
