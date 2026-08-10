<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\OrganizationProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactPageController extends Controller
{
    public function __invoke(): View
    {
        $profile = OrganizationProfile::query()->first();

        return view('pages.contact', [
            'profile' => $profile,
            'contactInfo' => [
                'address' => $profile?->address ?: 'Jl. Demang Lebar Daun No. 2845, Palembang, Sumatera Selatan, Indonesia 30137',
                'phone' => $profile?->phone ?: '+62 811-7878-2226 / (0711) 573-0123',
                'email' => $profile?->email ?: 'info@ibgksumsel.or.id',
                'partnership_email' => 'kemitraan@ibgksumsel.or.id',
                'website' => $profile?->website ?: 'www.ibgksumsel.or.id',
                'hours' => 'Senin – Jumat (08.00 – 17.00 WIB), Sabtu – Minggu (berdasarkan kegiatan)',
                'partnership_phone' => '+62 811-7878-2226',
            ],
            'socialLinks' => [
                'instagram' => [
                    'url' => $profile?->instagram,
                    'label' => '@ibgksumsel',
                ],
                'tiktok' => [
                    'url' => $profile?->tiktok,
                    'label' => '@ibgksumsel',
                ],
                'youtube' => [
                    'url' => $profile?->youtube,
                    'label' => 'IBGK Sumsel',
                ],
                'facebook' => [
                    'url' => $profile?->facebook,
                    'label' => 'IBGK Sumsel',
                ],
                'email' => [
                    'url' => filled($profile?->email) ? 'mailto:'.$profile->email : 'mailto:info@ibgksumsel.or.id',
                    'label' => $profile?->email ?: 'info@ibgksumsel.or.id',
                ],
            ],
            'mapEmbed' => 'https://maps.google.com/maps?q=Demang+Lebar+Daun+Palembang&t=&z=15&ie=UTF8&iwloc=&output=embed',
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'privacy' => ['accepted'],
        ]);

        ContactMessage::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?: 'Pesan Kontak',
            'message' => $validated['message'],
            'status' => ContactMessage::STATUS_NEW,
        ]);

        return redirect()
            ->route('contact')
            ->with('contact_success', 'Terima kasih! Pesan Anda telah kami terima dan akan segera ditindaklanjuti.');
    }
}
