<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_nasabah')->constrained('nasabahs')->onDelete('cascade');
            $table->enum('jenis_transaksi', ['masuk', 'keluar']);
            $table->foreignId('id_jenis')->nullable()->constrained('jenis_sampahs')->onDelete('set null');
            $table->decimal('berat', 10, 2)->nullable(); // hanya diisi jika masuk
            $table->decimal('harga_per_kg', 10, 2)->nullable(); // harga saat transaksi
            $table->decimal('subtotal', 15, 2); // total uang masuk atau keluar
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
