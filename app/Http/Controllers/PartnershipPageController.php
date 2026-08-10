<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Models\Partner;
use App\Models\PartnershipInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnershipPageController extends Controller
{
    /** @var array<int, array{title: string, description: string, icon: string}> */
    public const PARTNERSHIP_TYPES = [
        [
            'title' => 'Sponsorship',
            'description' => 'Dukungan finansial atau material untuk program dan kegiatan IBGK Sumsel.',
            'icon' => 'handshake',
        ],
        [
            'title' => 'Program Kolaborasi',
            'description' => 'Kerja sama program bersama mitra untuk dampak yang lebih luas.',
            'icon' => 'users',
        ],
        [
            'title' => 'Pendidikan & Pelatihan',
            'description' => 'Kolaborasi pengembangan kompetensi dan karakter generasi muda.',
            'icon' => 'academic',
        ],
        [
            'title' => 'Promosi & Publikasi',
            'description' => 'Sinergi promosi kegiatan melalui media dan kanal publikasi mitra.',
            'icon' => 'megaphone',
        ],
        [
            'title' => 'Sosial & Kemanusiaan',
            'description' => 'Program sosial, bakti masyarakat, dan aksi kemanusiaan bersama.',
            'icon' => 'heart',
        ],
        [
            'title' => 'Kebudayaan & Pariwisata',
            'description' => 'Pelestarian budaya dan promosi pariwisata Sumatera Selatan.',
            'icon' => 'building',
        ],
    ];

    /** @var array<int, array{title: string, description: string, icon: string}> */
    public const CTA_FEATURES = [
        [
            'title' => 'Program Berkualitas',
            'description' => 'Rangkaian kegiatan terencana dengan standar profesional.',
            'icon' => 'star',
        ],
        [
            'title' => 'Dampak Nyata',
            'description' => 'Kontribusi langsung bagi generasi muda dan masyarakat.',
            'icon' => 'target',
        ],
        [
            'title' => 'Citra Positif',
            'description' => 'Branding mitra terhubung dengan nilai positif kepemudaan.',
            'icon' => 'shield',
        ],
        [
            'title' => 'Jaringan Luas',
            'description' => 'Akses jejaring kampus, alumni, dan komunitas Sumsel.',
            'icon' => 'network',
        ],
    ];

    public function __invoke(): View
    {
        $profile = OrganizationProfile::query()->first();
        $partners = Partner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with('category')
            ->get();

        $partnerCount = max($partners->count(), 20);

        return view('pages.partnership', [
            'profile' => $profile,
            'partners' => $partners,
            'partnerPages' => $partners->chunk(12),
            'partnershipTypes' => self::PARTNERSHIP_TYPES,
            'ctaFeatures' => self::CTA_FEATURES,
            'stats' => [
                'partners' => $partnerCount.'+',
                'since' => '2002',
                'sectors' => 'Beragam Sektor',
                'goal' => 'Satu Tujuan',
            ],
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'partnership_type' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        PartnershipInquiry::query()->create([
            ...$validated,
            'status' => PartnershipInquiry::STATUS_NEW,
        ]);

        return redirect()
            ->route('partnership')
            ->with('partnership_success', 'Terima kasih! Pengajuan kerja sama Anda telah kami terima dan akan segera ditindaklanjuti.');
    }
}
