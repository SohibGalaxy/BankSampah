<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class TransaksiChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Transaksi 30 Hari Terakhir';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {
        // Ambil tanggal 30 hari terakhir
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Ambil data transaksi per tanggal
        $transaksiPerTanggal = Transaksi::whereBetween('tanggal', [$startDate, $endDate])
            ->selectRaw('tanggal, count(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->tanggal)->format('Y-m-d'));

        // Inisialisasi label dan data
        $labels = [];
        $data = [];

        foreach (range(0, 29) as $i) {
            $tanggal = $startDate->copy()->addDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($tanggal)->translatedFormat('d M');
            $data[] = $transaksiPerTanggal[$tanggal]->jumlah ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => $data,
                   'backgroundColor' => 'rgba(234, 179, 8, 0.5)',   // warna kuning semi transparan
'                   borderColor'     => 'rgba(234, 179, 8, 1)',     // warna kuning solid
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Bisa diubah jadi 'bar' atau 'radar' jika diinginkan
    }
}

