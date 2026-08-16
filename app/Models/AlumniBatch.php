<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AlumniBatch extends Model
{
    use HasFactory;

    public const FIRST_ELECTION_YEAR = 2002;

    public const FOUNDING_YEAR = 1999;

    public const MEMBERS_PER_YEAR = 30;

    public const YEAR_RANGE_SPAN = 5;

    public const SIDEBAR_PAGE_SIZE = 5;

    public const CATEGORY_ELECTION = 'election';

    public const CATEGORY_FOUNDERS = 'founders';

    public const CATEGORY_HONORARY = 'honorary';

    public const FOUNDERS_SLUG = 'pendiri';

    public const HONORARY_SLUG = 'anggota-kehormatan';

    public const HONORARY_YEAR = 1998;

    protected $fillable = [
        'election_id',
        'name',
        'slug',
        'category',
        'year',
        'description',
        'photo',
        'historical_member_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'historical_member_count' => 'integer',
            'is_active' => 'boolean',
            'category' => 'string',
        ];
    }

    public function isFounders(): bool
    {
        return $this->category === self::CATEGORY_FOUNDERS;
    }

    public function isHonorary(): bool
    {
        return $this->category === self::CATEGORY_HONORARY;
    }

    public function isElection(): bool
    {
        return $this->category === self::CATEGORY_ELECTION;
    }

    public function scopeElection(Builder $query): Builder
    {
        return $query->where('category', self::CATEGORY_ELECTION);
    }

    public function scopeFounders(Builder $query): Builder
    {
        return $query->where('category', self::CATEGORY_FOUNDERS);
    }

    public function scopeHonorary(Builder $query): Builder
    {
        return $query->where('category', self::CATEGORY_HONORARY);
    }

    public function scopeActiveUpToCurrentYear(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where('year', '<=', (int) now()->format('Y'));
    }

    public function scopeWithPublicMemberCount(Builder $query): Builder
    {
        return $query->withCount(['alumni as public_members_count' => fn (Builder $builder) => $builder
            ->where('is_public', true)
            ->where('is_active', true),
        ]);
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function alumni(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }

    public function publicMemberCount(): int
    {
        if (isset($this->public_members_count)) {
            return (int) $this->public_members_count;
        }

        return (int) $this->alumni()
            ->where('is_public', true)
            ->where('is_active', true)
            ->count();
    }

    public function displayMemberCount(): int
    {
        if ($this->isFounders() || $this->isHonorary()) {
            $recorded = $this->publicMemberCount();

            return $recorded > 0 ? $recorded : (int) $this->historical_member_count;
        }

        $year = (int) $this->year;
        $currentYear = (int) now()->format('Y');

        if ($year >= self::FIRST_ELECTION_YEAR && $year <= $currentYear) {
            return self::MEMBERS_PER_YEAR;
        }

        $recorded = $this->publicMemberCount();

        return $recorded > 0 ? $recorded : (int) $this->historical_member_count;
    }

    public static function electionYearCount(?int $throughYear = null): int
    {
        $throughYear ??= (int) now()->format('Y');

        if ($throughYear < self::FIRST_ELECTION_YEAR) {
            return 0;
        }

        return $throughYear - self::FIRST_ELECTION_YEAR + 1;
    }

    public static function totalPublicMembersUpToCurrentYear(): int
    {
        return self::electionYearCount() * self::MEMBERS_PER_YEAR;
    }

    public static function activeBatchCountUpToCurrentYear(): int
    {
        return self::electionYearCount();
    }

    /** @return list<array{start: int, end: int, label: string, slug: string, member_count: int}> */
    public static function electionYearRanges(?int $span = null): array
    {
        $span ??= self::YEAR_RANGE_SPAN;
        $currentYear = (int) now()->format('Y');
        $ranges = [];

        for ($start = self::FIRST_ELECTION_YEAR; $start <= $currentYear; $start += $span) {
            $end = min($start + $span - 1, $currentYear);

            $ranges[] = [
                'start' => $start,
                'end' => $end,
                'label' => "{$start}–{$end}",
                'slug' => "{$start}-{$end}",
                'member_count' => ($end - $start + 1) * self::MEMBERS_PER_YEAR,
            ];
        }

        return array_reverse($ranges);
    }

    public static function rangeSlugForYear(int $year): string
    {
        $span = self::YEAR_RANGE_SPAN;
        $start = self::FIRST_ELECTION_YEAR + (int) floor(($year - self::FIRST_ELECTION_YEAR) / $span) * $span;
        $end = min($start + $span - 1, (int) now()->format('Y'));

        return "{$start}-{$end}";
    }

    /** @return array{start: int, end: int, label: string, slug: string, member_count: int}|null */
    public static function rangeForSlug(string $slug): ?array
    {
        foreach (self::electionYearRanges() as $range) {
            if ($range['slug'] === $slug) {
                return $range;
            }
        }

        return null;
    }

    /** @return Collection<int, self> */
    public static function electionBatchesOrdered(): Collection
    {
        static::syncElectionYearBatches();

        return static::query()
            ->election()
            ->where('is_active', true)
            ->whereBetween('year', [self::FIRST_ELECTION_YEAR, (int) now()->format('Y')])
            ->withPublicMemberCount()
            ->orderByDesc('year')
            ->get();
    }

    public static function foundersBatch(): ?self
    {
        static::syncFoundersBatch();

        return static::query()
            ->founders()
            ->where('is_active', true)
            ->withPublicMemberCount()
            ->first();
    }

    public static function honoraryBatch(): ?self
    {
        static::syncHonoraryBatch();

        return static::query()
            ->honorary()
            ->where('is_active', true)
            ->withPublicMemberCount()
            ->first();
    }

    /** @return Collection<int, self> */
    public static function orderedForPublicSite(): Collection
    {
        $batches = static::electionBatchesOrdered();
        $founders = static::foundersBatch();
        $honorary = static::honoraryBatch();

        if ($founders) {
            $batches->push($founders);
        }

        if ($honorary) {
            $batches->push($honorary);
        }

        return $batches->values();
    }

    /** @return Collection<int, self> */
    public static function batchesWithPublicAlumniOrdered(): Collection
    {
        static::syncElectionYearBatches();
        static::syncFoundersBatch();

        return static::query()
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query
                    ->where(fn (Builder $builder) => $builder
                        ->election()
                        ->whereBetween('year', [self::FIRST_ELECTION_YEAR, (int) now()->format('Y')]))
                    ->orWhere(fn (Builder $builder) => $builder->founders());
            })
            ->withPublicMemberCount()
            ->orderByDesc('year')
            ->get()
            ->filter(fn (self $batch): bool => $batch->publicMemberCount() > 0)
            ->values();
    }

    /** @return Collection<int, self> */
    public static function sidebarBatchesOrdered(): Collection
    {
        return static::batchesWithPublicAlumniOrdered();
    }

    public static function sidebarPageCount(): int
    {
        $count = static::sidebarBatchesOrdered()->count();

        return max(1, (int) ceil($count / self::SIDEBAR_PAGE_SIZE));
    }

    public static function sidebarPageForBatch(self $batch): int
    {
        $index = static::sidebarBatchesOrdered()->search(
            fn (self $item): bool => $item->id === $batch->id
        );

        if ($index === false) {
            return 1;
        }

        return (int) floor($index / self::SIDEBAR_PAGE_SIZE) + 1;
    }

    /** @return Collection<int, self> */
    public static function sidebarBatchesForPage(int $page): Collection
    {
        $page = max(1, min($page, static::sidebarPageCount()));

        return static::sidebarBatchesOrdered()
            ->slice(($page - 1) * self::SIDEBAR_PAGE_SIZE, self::SIDEBAR_PAGE_SIZE)
            ->values();
    }

    public static function syncFoundersBatch(): void
    {
        static::query()->updateOrCreate(
            ['slug' => self::FOUNDERS_SLUG],
            [
                'name' => 'PENDIRI',
                'category' => self::CATEGORY_FOUNDERS,
                'year' => self::FOUNDING_YEAR,
                'is_active' => true,
            ]
        );
    }

    public static function syncHonoraryBatch(): void
    {
        static::query()->updateOrCreate(
            ['slug' => self::HONORARY_SLUG],
            [
                'name' => 'ANGGOTA KEHORMATAN',
                'category' => self::CATEGORY_HONORARY,
                'year' => self::HONORARY_YEAR,
                'is_active' => true,
            ]
        );
    }

    public static function syncElectionYearBatches(): void
    {
        $currentYear = (int) now()->format('Y');
        $expectedCount = self::electionYearCount($currentYear);

        if (static::query()->election()->activeUpToCurrentYear()->count() >= $expectedCount) {
            return;
        }

        for ($year = self::FIRST_ELECTION_YEAR; $year <= $currentYear; $year++) {
            $name = "BGK Sumsel {$year}";

            $batch = static::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'year' => $year,
                    'category' => self::CATEGORY_ELECTION,
                    'is_active' => true,
                ]
            );

            if ($batch->wasRecentlyCreated || blank($batch->historical_member_count)) {
                $batch->update(['historical_member_count' => self::MEMBERS_PER_YEAR]);
            }
        }
    }

    /** @return Collection<int, self> */
    public static function forPublicSite(): Collection
    {
        static::syncFoundersBatch();
        static::syncHonoraryBatch();

        return static::query()
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query
                    ->where(fn (Builder $builder) => $builder
                        ->election()
                        ->whereBetween('year', [self::FIRST_ELECTION_YEAR, (int) now()->format('Y')]))
                    ->orWhere(fn (Builder $builder) => $builder->founders())
                    ->orWhere(fn (Builder $builder) => $builder->honorary());
            })
            ->withPublicMemberCount()
            ->orderByDesc('year')
            ->get();
    }
}
