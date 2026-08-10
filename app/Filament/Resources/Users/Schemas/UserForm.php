<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Support\Roles;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Akun Pengguna')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->helperText(fn (string $operation): string => $operation === 'edit'
                            ? 'Kosongkan jika password tidak diubah.'
                            : 'Minimal 8 karakter.')
                        ->minLength(8)
                        ->columnSpanFull(),
                ]),

            Section::make('Role & Akses')
                ->schema([
                    Select::make('roles')
                        ->label('Role')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->default(fn (): array => Role::query()
                            ->where('name', Roles::PENGUNJUNG)
                            ->pluck('id')
                            ->all())
                        ->helperText('Super Admin dan Admin dapat mengakses panel admin. Pengunjung dan Anggota hanya dashboard pengguna.')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
