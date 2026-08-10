<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniBatch;
use App\Models\HonoraryMember;
use App\Models\OrganizationProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniPageController extends Controller
{
    public function show(Alumni $alumni): View
    {
        abort_unless($alumni->is_public && $alumni->is_active, 404);

        return view('pages.alumni-show', [
            'profile' => OrganizationProfile::query()->first(),
            'alumni' => $alumni->load('alumniBatch'),
        ]);
    }

    public function __invoke(Request $request): View
    {
        $batches = AlumniBatch::query()
            ->where('is_active', true)
            ->orderBy('year')
            ->get();

        $selectedBatch = $batches->firstWhere('slug', $request->string('angkatan')->toString())
            ?? $batches->first();

        $search = trim((string) $request->string('q'));
        $gender = $request->string('gender')->toString();

        $alumniQuery = Alumni::query()
            ->with('alumniBatch')
            ->where('is_public', true)
            ->where('is_active', true)
            ->when($selectedBatch, fn ($query) => $query->where('alumni_batch_id', $selectedBatch->id))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($builder) use ($search): void {
                    $builder
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('university', 'like', "%{$search}%")
                        ->orWhere('profession', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->when(in_array($gender, ['male', 'female'], true), fn ($query) => $query->where('gender', $gender))
            ->orderBy('name');

        $alumni = $alumniQuery->paginate(12)->withQueryString();

        $totalAlumni = (int) $batches->sum('historical_member_count');
        if ($totalAlumni === 0) {
            $totalAlumni = Alumni::query()->where('is_public', true)->where('is_active', true)->count();
        }

        return view('pages.alumni', [
            'profile' => OrganizationProfile::query()->first(),
            'batches' => $batches,
            'selectedBatch' => $selectedBatch,
            'alumni' => $alumni,
            'search' => $search,
            'gender' => $gender,
            'totalAlumni' => $totalAlumni,
            'batchCount' => $batches->count(),
            'honoraryCount' => HonoraryMember::query()->where('is_active', true)->count(),
        ]);
    }
}
