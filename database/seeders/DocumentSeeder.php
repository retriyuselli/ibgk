<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $path = 'documents/panduan-pemilihan-bgk-sumsel.pdf';

        if (! Storage::disk('local')->exists($path)) {
            Storage::disk('local')->put($path, $this->minimalPdf(
                'Panduan Pemilihan BGK Sumatera Selatan',
                'Dokumen panduan resmi IBGK Sumsel untuk peserta Pemilihan Bujang Gadis Kampus Sumatera Selatan.'
            ));
        }

        Document::query()->updateOrCreate(
            ['slug' => 'panduan-pemilihan-bgk'],
            [
                'title' => 'Panduan Pemilihan BGK Sumatera Selatan',
                'category' => 'Panduan',
                'file' => $path,
                'description' => 'Panduan lengkap pendaftaran, persyaratan, dan tahapan seleksi BGK Sumsel.',
                'is_public' => true,
                'is_active' => true,
            ]
        );
    }

    private function minimalPdf(string $title, string $body): string
    {
        $escapedTitle = $this->escapePdfText($title);
        $escapedBody = $this->escapePdfText($body);

        $content = <<<PDF
BT
/F1 18 Tf
72 760 Td
({$escapedTitle}) Tj
0 -28 Td
/F1 11 Tf
({$escapedBody}) Tj
ET
PDF;

        $objects = [];
        $objects[] = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
        $objects[] = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
        $objects[] = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
        $objects[] = '4 0 obj\n<< /Length '.strlen($content)." >>\nstream\n{$content}\nendstream\nendobj\n";
        $objects[] = "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xrefPosition = strlen($pdf);
        $pdf .= "xref\n0 ".count($offsets)."\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i < count($offsets); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n<< /Size ".count($offsets)." /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefPosition}\n%%EOF";

        return $pdf;
    }

    private function escapePdfText(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}
