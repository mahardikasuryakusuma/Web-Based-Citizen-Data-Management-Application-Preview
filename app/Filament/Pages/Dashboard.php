<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ChartKepalaKeluarga;
use App\Filament\Widgets\ChartStatusWarga;
use App\Filament\Widgets\ChartWarga;
use App\Filament\Widgets\TotalWarga;
use Filament\Pages\Dashboard as BasePage;
use Filament\Widgets\AccountWidget;

class Dashboard extends BasePage
{
    protected static ?string $navigationIcon = 'heroicon-m-home';
    // Menambahkan widget ke dashboard
    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            TotalWarga::class,
            ChartWarga::class,
            ChartKepalaKeluarga::class,
            ChartStatusWarga::class,
        ];
    }
}
