<?php

namespace App\Http\Controllers;

use App\Models\HonoraryMember;
use App\Models\OrganizationMember;
use App\Models\OrganizationPeriod;
use App\Models\OrganizationProfile;
use Illuminate\Support\Collection;
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
            ->with(['position', 'division', 'alumni.alumniBatch'])
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

        $divisionGroups = $this->divisionGroups($remaining);
        $divisionLeads = $divisionGroups
            ->pluck('lead')
            ->filter()
            ->concat(
                $remaining->filter(function (OrganizationMember $member): bool {
                    return (bool) $member->position?->isDivisionLead()
                        && blank($member->organization_division_id);
                })
            )
            ->unique('id')
            ->values();

        $ungroupedMembers = $remaining
            ->reject(fn (OrganizationMember $member): bool => $officers->contains('id', $member->id))
            ->reject(fn (OrganizationMember $member): bool => $divisionLeads->contains('id', $member->id))
            ->reject(fn (OrganizationMember $member): bool => filled($member->organization_division_id))
            ->values();

        $hasMore = $ungroupedMembers->isNotEmpty()
            || $divisionGroups->contains(fn (array $group): bool => $group['members']->isNotEmpty());

        $honoraryMembers = HonoraryMember::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.board', [
            'profile' => $profile,
            'period' => $period,
            'chair' => $chair,
            'officers' => $officers,
            'divisionLeads' => $divisionLeads,
            'divisionGroups' => $divisionGroups,
            'ungroupedMembers' => $ungroupedMembers,
            'hasMore' => $hasMore,
            'honoraryMembers' => $honoraryMembers,
            'hasStructure' => $members->isNotEmpty(),
        ]);
    }

    /**
     * @param  Collection<int, OrganizationMember>  $members
     * @return Collection<int, array{division: mixed, lead: ?OrganizationMember, members: Collection<int, OrganizationMember>}>
     */
    private function divisionGroups(Collection $members): Collection
    {
        return $members
            ->filter(fn (OrganizationMember $member): bool => filled($member->organization_division_id))
            ->groupBy('organization_division_id')
            ->map(function (Collection $groupMembers): array {
                $lead = $groupMembers->first(
                    fn (OrganizationMember $member): bool => (bool) $member->position?->isDivisionLead()
                );

                return [
                    'division' => $groupMembers->first()?->division,
                    'lead' => $lead,
                    'members' => $groupMembers
                        ->reject(fn (OrganizationMember $member): bool => $lead && $member->id === $lead->id)
                        ->sortBy(fn (OrganizationMember $member): int => (int) $member->sort_order)
                        ->values(),
                ];
            })
            ->sortBy(fn (array $group): int => (int) ($group['division']?->sort_order ?? 99))
            ->values();
    }
}
