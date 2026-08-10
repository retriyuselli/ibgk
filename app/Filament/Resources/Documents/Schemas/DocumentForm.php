<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Document;
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

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Dokumen')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Dokumen')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get, ?string $state, ?string $old): void {
                            $currentSlug = $get('slug');
                            if (blank($currentSlug) || $currentSlug === Str::slug((string) $old)) {
                                $set('slug', Str::slug((string) $state));
                            }
                        })
                        ->columnSpanFull(),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Select::make('category')
                        ->label('Kategori')
                        ->options([
                            'Organisasi' => 'Organisasi',
                            'Pemilihan BGK' => 'Pemilihan BGK',
                            'Panduan' => 'Panduan',
                            'Proposal' => 'Proposal',
                            'Media Kit' => 'Media Kit',
                            'Formulir' => 'Formulir',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->searchable()
                        ->nullable()
                        ->native(false),
                    FileUpload::make('file')
                        ->label('File')
                        ->required()
                        ->directory('documents')
                        ->disk(Document::storageDisk())
                        ->visibility('private')
                        ->acceptedFileTypes([
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        ])
                        ->maxSize(10240)
                        ->helperText('PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maksimal 10 MB. Disimpan di private storage.')
                        ->columnSpanFull(),
                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->columnSpanFull(),
                    Toggle::make('is_public')
                        ->label('Publik')
                        ->default(true)
                        ->inline(false)
                        ->helperText('Menandai dokumen untuk akses publik nanti. File tetap disimpan di private disk.'),
                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true)
                        ->inline(false),
                ]),
        ]);
    }
}
