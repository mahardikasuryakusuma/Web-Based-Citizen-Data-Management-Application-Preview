<?php

namespace App\Filament\Widgets;

use App\Models\RT;
use Filament\Widgets\ChartWidget;

class ChartWarga extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Warga Tiap RT';
    protected static ?string $pollingInterval = null;
  protected function getData(): array
{
    // Mendapatkan jumlah warga dari setiap RT
    $rts = RT::get();
    $data = $rts->map(function ($rt) {
        return $rt->jumlah_warga;
    });

    // Ambil nama RT untuk dijadikan label
    $labels = $rts->pluck('nama');

    return [
        'datasets' => [
            [
                'label' => 'Jumlah Warga',
                'data' => $data->toArray(),
                'backgroundColor' => 'rgba(75, 192, 192, 0.3)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'hoverBackgroundColor' => 'rgba(153, 102, 255, 0.2)',
                'hoverBorderColor' => 'rgba(153, 102, 255, 1)',
            ],
        ],
        'labels' => $labels->toArray(),
    ];
}

    protected function getType(): string
    {
        return 'bar';
    }
}
