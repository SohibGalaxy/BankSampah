<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;

class TransaksiDonutChart extends ChartWidget
{
    protected static ?string $heading = 'Persentase Transaksi Masuk dan Keluar';
     protected static ?int $sort = 2;
    

    protected static ?string $maxHeight = '275px';

    protected function getData(): array
    {
        $totalMasuk = Transaksi::where('jenis_transaksi', 'masuk')->count();
        $totalKeluar = Transaksi::where('jenis_transaksi', 'keluar')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Transaksi',
                    'data' => [$totalMasuk, $totalKeluar],
                    'backgroundColor' => ['#16a34a', '#dc2626'], // Hijau dan merah
                ],
            ],
            'labels' => ['Masuk', 'Keluar'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
