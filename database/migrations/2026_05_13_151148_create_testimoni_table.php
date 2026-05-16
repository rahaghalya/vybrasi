<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimoni', function (Blueprint $table) {
            $table->id();

            $table->string('nama');

            $table->text('isi_testimoni');

            $table->integer('rating')->default(5);

            // relasi ke produk (opsional)
            $table->foreignId('id_produk')
                ->nullable()
                ->constrained('produk')
                ->nullOnDelete();

            $table->boolean('is_tampil')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimoni');
    }
};