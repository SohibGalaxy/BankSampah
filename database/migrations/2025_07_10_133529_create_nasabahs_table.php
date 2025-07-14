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
        Schema::create('nasabahs', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->text('alamat');
                $table->string('no_telpon')->nullable();
                $table->string('telegram_chat_id')->nullable(); // untuk notifikasi
                $table->date('tgl_daftar');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabahs');
    }
};
