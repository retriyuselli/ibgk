<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniBatch;
use App\Models\OrganizationProfile;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        $profile = OrganizationProfile::query()->first();
        $honoraryBatch = AlumniBatch::honoraryBatch();

        return view('pages.about', [
            'profile' => $profile,
            'yearsActive' => $profile?->founded_at
                ? max(1, (int) now()->format('Y') - (int) $profile->founded_at->format('Y'))
                : 27,
            'honoraryMembers' => Alumni::query()
                ->where('is_public', true)
                ->where('is_active', true)
                ->when(
                    $honoraryBatch,
                    fn ($query) => $query->where('alumni_batch_id', $honoraryBatch->id),
                    fn ($query) => $query->whereRaw('0 = 1'),
                )
                ->orderBy('name')
                ->get(),
            'honoraryDirectoryUrl' => route('alumni', [
                'angkatan' => AlumniBatch::HONORARY_SLUG,
            ]),
        ]);
    }
}
