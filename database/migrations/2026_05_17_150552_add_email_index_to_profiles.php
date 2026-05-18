<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Kita hanya perlu menambahkan index pada email
            // (Username tidak perlu ditambah ->unique() karena di backup aslinya sudah unik)
            $table->index('email'); 
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Menghapus index jika terjadi rollback
            $table->dropIndex(['email']); 
        });
    }
};