<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Document;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Dokumen')->columns(2)->schema([
                TextEntry::make('title')->label('Judul Dokumen'),
                TextEntry::make('slug')->label('Slug'),
                TextEntry::make('category')->label('Kategori')->placeholder('-'),
                TextEntry::make('file')
                    ->label('File')
                    ->formatStateUsing(fn (?string $state): string => $state ? basename($state) : '-'),
                TextEntry::make('description')->label('Deskripsi')->placeholder('-')->columnSpanFull(),
                IconEntry::make('is_public')->label('Publik')->boolean(),
                IconEntry::make('is_active')->label('Aktif')->boolean(),
                TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y H:i'),
            ]),
        ]);
    }
}
