<?php

namespace App\Filament\Resources\Alumnis\Widgets;

use App\Models\Alumni;
use App\Models\AlumniBatch;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AlumniStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()?->can('ViewAny:Alumni') ?? false;
    }

    protected function getStats(): array
    {
        $public = Alumni::query()
            ->where('is_active', true)
            ->where('is_public', true)
            ->count();
        $bujang = Alumni::query()->genderCategory('bujang')->count();
        $gadis = Alumni::query()->genderCategory('gadis')->count();
        $honorary = Alumni::query()
            ->whereHas('alumniBatch', fn ($query) => $query->honorary())
            ->count();
        $pendingForms = Alumni::query()
            ->whereNull('profile_submitted_at')
            ->whereNotNull('profile_token')
            ->where(function ($query): void {
                $query
                    ->whereNull('profile_token_expires_at')
                    ->orWhere('profile_token_expires_at', '>', now());
            })
            ->count();
        $batches = AlumniBatch::query()->election()->activeUpToCurrentYear()->count();
        $formulaTotal = $batches * AlumniBatch::MEMBERS_PER_YEAR;

        return [
            Stat::make('Total Alumni', number_format($formulaTotal))
                ->description(AlumniBatch::MEMBERS_PER_YEAR.' × '.number_format($batches).' tahun aktif · '.number_format($public).' tampil di website')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),
            Stat::make('Bujang', number_format($bujang))
                ->description('Alumni kategori Bujang Kampus')
                ->descriptionIcon('heroicon-m-user')
                ->color('info'),
            Stat::make('Gadis', number_format($gadis))
                ->description('Alumni kategori Gadis Kampus')
                ->descriptionIcon('heroicon-m-user')
                ->color('danger'),
            Stat::make('Angkatan', number_format($batches))
                ->description(number_format($honorary).' anggota kehormatan · '.number_format($pendingForms).' formulir menunggu')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('warning'),
        ];
    }
}
