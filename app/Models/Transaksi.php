<?php

namespace App\Models;

use App\Helpers\TelegramHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'id_nasabah',
        'jenis_transaksi',
        'id_jenis',
        'berat',
        'harga_per_kg',
        'subtotal',
        'tanggal',
    ];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah');
    }

    public function jenisSampah(): BelongsTo
    {
        return $this->belongsTo(JenisSampah::class, 'id_jenis');
    }

    // Update tabungan dan kirim notifikasi Telegram
    protected static function booted(): void
    {
        static::created(function ($transaksi) {
            $tabungan = Tabungan::firstOrCreate(
                ['id_nasabah' => $transaksi->id_nasabah],
                ['saldo' => 0]
            );

            // Update saldo
            if ($transaksi->jenis_transaksi === 'masuk') {
                $tabungan->saldo += $transaksi->subtotal;
            } elseif ($transaksi->jenis_transaksi === 'keluar') {
                if ($tabungan->saldo >= $transaksi->subtotal) {
                    $tabungan->saldo -= $transaksi->subtotal;
                } else {
                    throw new \Exception("Saldo tabungan tidak cukup untuk transaksi keluar.");
                }
            }

            $tabungan->save();

            // Kirim notifikasi Telegram
            $nasabah = $transaksi->nasabah;

            if ($nasabah && $nasabah->telegram_chat_id) {
                $jenis = ucfirst($transaksi->jenis_transaksi); // Masuk / Keluar
                $tanggal = date('d M Y', strtotime($transaksi->tanggal));
                $subtotal = number_format($transaksi->subtotal, 0, ',', '.');
                $saldoAkhir = number_format($tabungan->saldo, 0, ',', '.');

                // Pilih emoji dan tanda jumlah
                $emoji = $jenis === 'Masuk' ? '📥' : '📤';
                $prefix = $jenis === 'Keluar' ? '-' : '+';

                $pesan = "{$emoji} Transaksi {$jenis}\n"
                    . "👤 Nama: {$nasabah->nama}\n"
                    . "🕒 Tanggal: {$tanggal}\n"
                    . "💵 Jumlah: {$prefix}Rp {$subtotal}\n"
                    . "💰 Saldo Sekarang: Rp {$saldoAkhir}";

                TelegramHelper::sendMessage($nasabah->telegram_chat_id, $pesan);
            }
        });
    }
}
