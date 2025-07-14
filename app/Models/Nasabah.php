<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nasabah extends Model
{
    protected $table = 'nasabahs';
    //protected $primaryKey = 'id_nasabah';
    protected $fillable = [
        'nama',
        'alamat',
        'no_telpon',
        'telegram_chat_id',
        'tgl_daftar',
    ];

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_nasabah');
    }

    public function tabungan(): HasOne
    {
        return $this->hasOne(Tabungan::class, 'id_nasabah');
    }
}
