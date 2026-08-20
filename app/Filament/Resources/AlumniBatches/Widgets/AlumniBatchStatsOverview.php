<?php

namespace App\Filament\Resources\AlumniBatches\Widgets;

use App\Models\Alumni;
use App\Models\AlumniBatch;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AlumniBatchStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()?->can('ViewAny:AlumniBatch') ?? false;
    }

    protected function getStats(): array
    {
        $total = AlumniBatch::query()->count();
        $active = AlumniBatch::query()->where('is_active', true)->count();
        $withPhoto = AlumniBatch::query()
            ->whereNotNull('photo')
            ->where('photo', '!=', '')
            ->count();
        $election = AlumniBatch::query()->election()->count();
        $yearFrom = AlumniBatch::query()->election()->min('year');
        $yearTo = AlumniBatch::query()->election()->max('year');
        $founders = AlumniBatch::query()->founders()->count();
        $honorary = AlumniBatch::query()->honorary()->count();
        $alumniCount = Alumni::query()->count();
        $activeYears = AlumniBatch::query()->election()->activeUpToCurrentYear()->count();
        $formulaTotal = $activeYears * AlumniBatch::MEMBERS_PER_YEAR;

        $electionYears = filled($yearFrom) && filled($yearTo)
            ? "Tahun {$yearFrom}–{$yearTo}"
            : 'Belum ada data tahun';

        return [
            Stat::make('Total Angkatan', number_format($total))
                ->description(number_format($active).' aktif · '.number_format($withPhoto).' punya foto')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('primary'),
            Stat::make('Pemilihan BGK', number_format($election))
                ->description($electionYears)
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),
            Stat::make('Pendiri & Kehormatan', number_format($founders + $honorary))
                ->description(number_format($founders).' pendiri · '.number_format($honorary).' kehormatan')
                ->descriptionIcon('heroicon-m-star')
                ->color('info'),
            Stat::make('Total Alumni', number_format($formulaTotal))
                ->description(AlumniBatch::MEMBERS_PER_YEAR.' × '.number_format($activeYears).' tahun aktif · '.number_format($alumniCount).' terinput')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
        ];
    }
}
