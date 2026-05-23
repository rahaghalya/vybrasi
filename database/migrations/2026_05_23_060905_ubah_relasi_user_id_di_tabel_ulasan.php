<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jualan_kopi.ulasan', function (Blueprint $table) {
            // 1. Putus relasi lama yang bikin error
            $table->dropForeign('ulasan_user_id_fkey');
            
            // 2. Sambungin ulang ke tabel profiles milik Abang aja
            // Kita hubungkan kolom user_id di ulasan dengan kolom user_id di profiles
            $table->foreign('user_id', 'ulasan_user_id_fkey')
                  ->references('user_id')->on('jualan_kopi.profiles')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('jualan_kopi.ulasan', function (Blueprint $table) {
            $table->dropForeign('ulasan_user_id_fkey');
            $table->foreign('user_id', 'ulasan_user_id_fkey')
                  ->references('id')->on('auth.users'); // Balikin ke aslinya kalo di-rollback
        });
    }
};