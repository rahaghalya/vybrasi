<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // PERBAIKAN: Menambahkan 'jualan_kopi.' di depan nama tabel
        Schema::create('jualan_kopi.settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        // PERBAIKAN: Menambahkan 'jualan_kopi.' di depan nama tabel
        Schema::dropIfExists('jualan_kopi.settings');
    }
};