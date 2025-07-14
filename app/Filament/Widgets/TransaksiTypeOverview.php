<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TransaksiTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $jumlahMasuk = Transaksi::where('jenis_transaksi', 'masuk')->count();
        $jumlahKeluar = Transaksi::where('jenis_transaksi', 'keluar')->count();
        $totalTransaksi = Transaksi::count();
        return [
             Stat::make('Total Transaksi', $totalTransaksi)
                ->description('Semua jenis transaksi')
                ->icon('heroicon-o-rectangle-stack')
                ->color('primary'),

            Stat::make('Transaksi Masuk', $jumlahMasuk)
                ->description('Jumlah pemasukan (sampah masuk)')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),

            Stat::make('Transaksi Keluar', $jumlahKeluar)
                ->description('Jumlah penarikan saldo')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('danger'),
        ];
    }
}
