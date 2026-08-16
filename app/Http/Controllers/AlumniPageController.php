<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniBatch;
use App\Models\HonoraryMember;
use App\Models\OrganizationProfile;
use Illuminate\Http\JsonResponse;
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

    public function __invoke(Request $request): View|JsonResponse
    {
        $batches = AlumniBatch::batchesWithPublicAlumniOrdered();

        $angkatanSlug = trim($request->string('angkatan')->toString());
        $isHonorary = $angkatanSlug === HonoraryMember::DIRECTORY_SLUG;
        $selectedBatch = $isHonorary
            ? null
            : ($batches->firstWhere('slug', $angkatanSlug) ?? $batches->first());

        $sidebarPages = AlumniBatch::sidebarPageCount();
        $sidebarPage = $request->integer('halaman');

        if ($sidebarPage < 1) {
            $sidebarPage = $selectedBatch
                ? AlumniBatch::sidebarPageForBatch($selectedBatch)
                : 1;
        }

        $sidebarPage = min($sidebarPage, $sidebarPages);
        $sidebarBatches = AlumniBatch::sidebarBatchesForPage($sidebarPage);
        $prevPageBatch = $sidebarPage > 1
            ? AlumniBatch::sidebarBatchesForPage($sidebarPage - 1)->first()
            : null;
        $nextPageBatch = $sidebarPage < $sidebarPages
            ? AlumniBatch::sidebarBatchesForPage($sidebarPage + 1)->first()
            : null;

        $search = trim((string) $request->string('q'));
        $gender = $isHonorary ? '' : $request->string('gender')->toString();

        $honoraryBatch = AlumniBatch::honoraryBatch();

        $honoraryQuery = HonoraryMember::query()
            ->where('is_active', true)
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($builder) use ($search): void {
                    $builder
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name');

        $honoraryMembers = $isHonorary
            ? $honoraryQuery->get()
            : collect();

        $alumniQuery = Alumni::query()
            ->with('alumniBatch')
            ->where('is_public', true)
            ->where('is_active', true)
            ->when($isHonorary, fn ($query) => $query->where('alumni_batch_id', $honoraryBatch?->id ?? 0))
            ->when(! $isHonorary && $selectedBatch, fn ($query) => $query->where('alumni_batch_id', $selectedBatch->id))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($builder) use ($search): void {
                    $builder
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('university', 'like', "%{$search}%")
                        ->orWhere('profession', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->when(in_array($gender, ['male', 'female', 'bujang', 'gadis'], true), fn ($query) => $query->genderCategory($gender))
            ->orderBy('name');

        $alumni = $alumniQuery->paginate(12)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.alumni.card-items', [
                    'alumni' => $alumni,
                ])->render(),
                'has_more' => $alumni->hasMorePages(),
                'next_page' => $alumni->hasMorePages() ? $alumni->currentPage() + 1 : null,
            ]);
        }

        $honoraryMemberCount = HonoraryMember::query()->where('is_active', true)->count();
        $honoraryAlumniCount = $honoraryBatch?->publicMemberCount() ?? 0;

        return view('pages.alumni', [
            'profile' => OrganizationProfile::query()->first(),
            'batches' => $batches,
            'sidebarBatches' => $sidebarBatches,
            'sidebarPage' => $sidebarPage,
            'sidebarPages' => $sidebarPages,
            'prevPageBatch' => $prevPageBatch,
            'nextPageBatch' => $nextPageBatch,
            'selectedBatch' => $selectedBatch,
            'isHonorary' => $isHonorary,
            'alumni' => $alumni,
            'honoraryMembers' => $honoraryMembers,
            'search' => $search,
            'gender' => $gender,
            'totalAlumni' => AlumniBatch::totalPublicMembersUpToCurrentYear(),
            'batchCount' => AlumniBatch::activeBatchCountUpToCurrentYear(),
            'honoraryCount' => $honoraryMemberCount + $honoraryAlumniCount,
        ]);
    }
}
