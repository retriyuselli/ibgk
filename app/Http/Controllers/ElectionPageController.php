<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Election;
use App\Models\OrganizationProfile;
use Illuminate\View\View;

class ElectionPageController extends Controller
{
    public function __invoke(): View
    {
        $election = Election::query()
            ->where('is_active', true)
            ->with([
                'stages' => fn ($q) => $q->orderBy('sort_order'),
                'requirements' => fn ($q) => $q->orderBy('sort_order'),
                'benefits' => fn ($q) => $q->orderBy('sort_order'),
                'participants' => fn ($q) => $q
                    ->where('is_public', true)
                    ->orderBy('full_name')
                    ->limit(12),
            ])
            ->latest('year')
            ->first();

        $pastElections = Election::query()
            ->when($election, fn ($q) => $q->whereKeyNot($election->id))
            ->orderByDesc('year')
            ->take(6)
            ->get();

        return view('pages.election', [
            'profile' => OrganizationProfile::query()->first(),
            'election' => $election,
            'participants' => $election?->participants ?? collect(),
            'pastElections' => $pastElections,
            'guideDocument' => Document::query()
                ->public()
                ->where('category', 'Panduan')
                ->latest()
                ->first(),
        ]);
    }
}
