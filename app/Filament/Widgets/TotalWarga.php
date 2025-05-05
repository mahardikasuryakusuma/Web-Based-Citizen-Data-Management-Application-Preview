<?php

namespace App\Filament\Widgets;

use App\Models\AnggotaKeluarga;
use App\Models\KepalaKeluarga;
use App\Models\RT;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalWarga extends BaseWidget
{
    // protected static ?string $pollingInterval = null;
    protected function getStats(): array
    {
        $anggotaKeluarga = AnggotaKeluarga::count();
        $kepalaKeluarga = KepalaKeluarga::count();
        $wargaTetap = KepalaKeluarga::where('status_warga', 1)->count();
        $wargaTidakTetap = KepalaKeluarga::where('status_warga', 0)->count();
        return [
            Stat::make('Jumlah RT', RT::count())
                ->icon('heroicon-m-clipboard-document-list'),
            Stat::make('Jumlah Kepala Keluarga', $kepalaKeluarga)
                ->icon('heroicon-s-user'),
            Stat::make('Jumlah Warga RW 11', $anggotaKeluarga + $kepalaKeluarga)
                ->icon('heroicon-s-user-group'),
            Stat::make('KK Tetap | KK Tidak Tetap', "$wargaTetap | $wargaTidakTetap")
                ->icon('heroicon-s-user-group'),
        ];
    }
}
