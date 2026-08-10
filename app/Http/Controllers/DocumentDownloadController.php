<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentDownloadController extends Controller
{
    public function __invoke(Document $document): StreamedResponse
    {
        abort_unless($document->is_public && $document->is_active, 404);
        abort_unless(
            filled($document->file) && Storage::disk(Document::storageDisk())->exists($document->file),
            404
        );

        $filename = basename($document->file);

        return Storage::disk(Document::storageDisk())->download($document->file, $filename);
    }
}
