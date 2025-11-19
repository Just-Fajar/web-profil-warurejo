<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah tipe kolom kategori dari enum ke string
        DB::statement("ALTER TABLE `galeri` MODIFY `kategori` VARCHAR(50) NOT NULL DEFAULT 'kegiatan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum asli
        DB::statement("ALTER TABLE `galeri` MODIFY `kategori` ENUM('kegiatan', 'infrastruktur', 'budaya', 'umum') NOT NULL DEFAULT 'umum'");
    }
};
