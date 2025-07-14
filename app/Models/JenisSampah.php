<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSampah extends Model
{
    protected $table = 'jenis_sampahs'; // ✅ penting agar tidak error

    //protected $primaryKey = 'id_jenis';

    protected $fillable = [
        'nama',
        'harga_per_kg',
    ];

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_jenis');
    }
}
