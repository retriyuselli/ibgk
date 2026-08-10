<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerLogoSeeder extends Seeder
{
    /** @var array<string, string> */
    private const REMOTE_LOGOS = [
        'bank-indonesia' => 'https://upload.wikimedia.org/wikipedia/commons/8/8e/Bank_Indonesia_logo.svg',
        'pt-telkomsel' => 'https://upload.wikimedia.org/wikipedia/commons/7/72/Telkomsel_2021_icon.svg',
        'pertamina' => 'https://upload.wikimedia.org/wikipedia/commons/9/9c/Pertamina_logo.svg',
        'bank-mandiri' => 'https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg',
        'telkom-indonesia' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Telkom_Indonesia_2013.svg',
        'universitas-sriwijaya' => 'https://upload.wikimedia.org/wikipedia/id/4/4e/Logo_Universitas_Sriwijaya.svg',
        'wardah-cosmetics' => 'https://upload.wikimedia.org/wikipedia/commons/8/8a/Wardah_logo.svg',
        'pln-uid-sumsel' => 'https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_PLN.svg',
    ];

    /** @var array<string, string> */
    private const FALLBACK_LABELS = [
        'dinas-pendidikan-provinsi-sumsel' => 'DISDIK SUMSEL',
        'pemerintah-provinsi-sumatera-selatan' => 'PEMPROV SUMSEL',
        'politeknik-negeri-sriwijaya' => 'POLSRI',
        'universitas-bina-darma' => 'UBD',
        'bank-sumsel-babel' => 'BANK SUMSEL',
        'aston-palembang-hotel' => 'ASTON',
        'palembang-indah-mall' => 'PIM',
        'sriwijaya-post' => 'SRIPO',
        'sonora-fm-palembang' => 'SONORA FM',
        'komunitas-generasi-muda-sumsel' => 'GENMUD SUMSEL',
        'dinas-pariwisata-provinsi-sumsel' => 'DISPAR SUMSEL',
        'dinas-kebudayaan-provinsi-sumsel' => 'DISBUD SUMSEL',
        'universitas-muhammadiyah-palembang' => 'UMP',
        'metro-tv-palembang' => 'METRO TV',
    ];

    public function run(): void
    {
        Storage::disk('public')->makeDirectory('partners/logos');

        Partner::query()->orderBy('sort_order')->each(function (Partner $partner): void {
            $path = $this->resolveLogoPath($partner);

            if ($path === null) {
                return;
            }

            $partner->update(['logo' => $path]);
        });
    }

    private function resolveLogoPath(Partner $partner): ?string
    {
        $filename = $partner->slug;
        $storagePath = "partners/logos/{$filename}";

        if ($remoteUrl = self::REMOTE_LOGOS[$partner->slug] ?? null) {
            $extension = Str::contains($remoteUrl, '.svg') ? 'svg' : 'png';
            $storedPath = "{$storagePath}.{$extension}";

            if ($this->downloadLogo($remoteUrl, $storedPath)) {
                return $storedPath;
            }
        }

        $label = self::FALLBACK_LABELS[$partner->slug] ?? $this->abbreviate($partner->name);
        $storedPath = "{$storagePath}.svg";

        Storage::disk('public')->put($storedPath, $this->fallbackSvg($label));

        return $storedPath;
    }

    private function downloadLogo(string $url, string $storagePath): bool
    {
        try {
            $response = Http::timeout(20)->get($url);

            if (! $response->successful() || blank($response->body())) {
                return false;
            }

            Storage::disk('public')->put($storagePath, $response->body());

            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    private function abbreviate(string $name): string
    {
        $ignored = ['pt', 'dan', 'the', 'of', 'provinsi', 'sumatera', 'selatan', 'palembang', 'negeri'];

        $words = collect(explode(' ', Str::upper($name)))
            ->map(fn (string $word) => trim($word, '.,'))
            ->filter(fn (string $word) => filled($word) && ! in_array(Str::lower($word), $ignored, true))
            ->values();

        if ($words->count() === 1) {
            return Str::limit($words->first(), 12, '');
        }

        return $words->take(3)->map(fn (string $word) => Str::substr($word, 0, 1))->join('');
    }

    private function fallbackSvg(string $label): string
    {
        $safeLabel = htmlspecialchars($label, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $fontSize = strlen($label) > 10 ? 14 : 16;

        return <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="240" height="96" viewBox="0 0 240 96" role="img" aria-label="{$safeLabel}">
            <rect width="240" height="96" rx="4" fill="#F7F4EF"/>
            <rect x="1" y="1" width="238" height="94" rx="3" fill="none" stroke="#0B1F3A" stroke-opacity="0.08"/>
            <text x="120" y="54" text-anchor="middle" font-family="Georgia, 'Times New Roman', serif" font-size="{$fontSize}" font-weight="700" fill="#0B1F3A">{$safeLabel}</text>
        </svg>
        SVG;
    }
}
