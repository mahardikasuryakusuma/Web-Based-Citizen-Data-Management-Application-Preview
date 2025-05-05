<?php

namespace App\Filament\Widgets;

use App\Models\KepalaKeluarga;
use Filament\Widgets\ChartWidget;

class ChartStatusWarga extends ChartWidget
{
    protected static ?string $heading = 'Status Warga';
    protected static ?string $pollingInterval = null;
    protected function getData(): array
    {
        // Menghitung jumlah warga tetap dan tidak tetap
        $total = KepalaKeluarga::count();
        $tetap = KepalaKeluarga::where('status_warga', 1)->count();
        $tidakTetap = KepalaKeluarga::where('status_warga', 0)->count();

        // Menghitung persentase
        $tetapPersen = $total > 0 ? ($tetap / $total) * 100 : 0;
        $tidakTetapPersen = $total > 0 ? ($tidakTetap / $total) * 100 : 0;

        return [
            'datasets' => [
                [
                    'data' => [$tetap, $tidakTetap],
                    'backgroundColor' => ['rgba(75, 192, 192, 0.4)', 'rgba(153, 102, 255, 0.4)'],
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'hoverBackgroundColor' => ['rgba(75, 192, 192, 0.2)','rgba(153, 102, 255, 0.2)'],
                    'hoverBorderColor' => 'rgba(153, 102, 255, 1)',
                ],
            ],
            'labels' => [
                'KK Tetap - ' . number_format($tetapPersen, 2) . '%',
                'KK Tidak Tetap - ' . number_format($tidakTetapPersen, 2) . '%'
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'labels' => [
                            'font' => [
                                'size' => 14,
                            ],
                        ],
                    ],
                    'tooltip' => [
                        'callbacks' => [
                            'label' => function($tooltipItem) {
                                return $tooltipItem->raw . ' warga';
                            },
                        ],
                        'bodyFont' => [
                            'size' => 16,
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
