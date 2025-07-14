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
        Schema::create('tabungans', function (Blueprint $table) {
                $table->id(); // primary key
                $table->foreignId('id_nasabah')
                    ->constrained('nasabahs')
                    ->onDelete('cascade')
                    ->unique(); // 1 nasabah hanya 1 tabungan
                $table->decimal('saldo', 15, 2)->default(0);
                $table->timestamp('tgl_update')->nullable(); // ✅ kolom tambahan
                $table->timestamps();
                    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabungans');
    }
};
