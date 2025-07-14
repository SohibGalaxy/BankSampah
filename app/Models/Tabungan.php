<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tabungan extends Model
{
    protected $table = 'tabungans';

    protected $fillable = [
        'id_nasabah',
        'saldo',
    ];

    protected $casts = [
        'saldo' => 'float',
    ];

    // default: timestamps aktif → created_at & updated_at
    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah');
    }
}
