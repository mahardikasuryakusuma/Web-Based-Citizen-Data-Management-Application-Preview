<?php

namespace App\Filament\Widgets;

use App\Models\RT;
use Filament\Widgets\ChartWidget;

class ChartKepalaKeluarga extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Kepala Keluarga Tiap RT';
    protected static ?string $pollingInterval = null;
    protected function getData(): array
    {
        $rt = RT::pluck('nama');
        // Mengambil jumlah kepala keluarga untuk setiap RT
        $rts = RT::withCount('kepalaKeluarga')->get();

        // Menghitung jumlah kepala keluarga untuk setiap RT
        $data = $rts->map(function ($rt) {
            return $rt->kepala_keluarga_count; // Hanya kepala keluarga
        });
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kepala Keluarga',
                    'data' => $data->toArray(),
                ],
            ],
            'labels' => $rt->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
