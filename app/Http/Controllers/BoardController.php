<?php

namespace App\Http\Controllers;

use App\Models\HonoraryMember;
use App\Models\OrganizationMember;
use App\Models\OrganizationPeriod;
use App\Models\OrganizationProfile;
use Illuminate\View\View;

class BoardController extends Controller
{
    public function __invoke(): View
    {
        $profile = OrganizationProfile::query()->first();
        $period = OrganizationPeriod::query()
            ->where('is_active', true)
            ->first()
            ?? OrganizationPeriod::query()->orderByDesc('start_year')->first();

        $members = OrganizationMember::query()
            ->with(['position', 'alumni.alumniBatch'])
            ->where('is_active', true)
            ->when(
                $period,
                fn ($query) => $query->where('organization_period_id', $period->id),
            )
            ->get()
            ->sortBy([
                fn (OrganizationMember $member): int => (int) ($member->position?->sort_order ?? 99),
                fn (OrganizationMember $member): int => (int) $member->sort_order,
            ])
            ->values();

        $chair = $members->first(fn (OrganizationMember $member): bool => (bool) $member->position?->isChair())
            ?? $members->first();

        $remaining = $members->reject(fn (OrganizationMember $member): bool => $chair && $member->id === $chair->id);

        $officers = $remaining
            ->filter(fn (OrganizationMember $member): bool => (bool) $member->position?->isCoreOfficer())
            ->values();

        if ($officers->count() < 4) {
            $officers = $officers
                ->concat($remaining->reject(fn (OrganizationMember $member): bool => $officers->contains('id', $member->id)))
                ->take(4)
                ->values();
        } else {
            $officers = $officers->take(4)->values();
        }

        $visibleIds = collect([$chair])->filter()->concat($officers)->pluck('id');

        $moreMembers = $remaining
            ->reject(fn (OrganizationMember $member): bool => $visibleIds->contains($member->id))
            ->values();

        $divisionMembers = $members
            ->filter(fn (OrganizationMember $member): bool => (bool) $member->position?->isDivisionLead())
            ->values();

        $honoraryMembers = HonoraryMember::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.board', [
            'profile' => $profile,
            'period' => $period,
            'chair' => $chair,
            'officers' => $officers,
            'moreMembers' => $moreMembers,
            'divisionMembers' => $divisionMembers,
            'honoraryMembers' => $honoraryMembers,
            'hasStructure' => $members->isNotEmpty(),
        ]);
    }
}
