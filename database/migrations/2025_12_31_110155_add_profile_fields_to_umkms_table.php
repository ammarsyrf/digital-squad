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
        Schema::table('umkm', function (Blueprint $table) {
            // Informasi Bisnis
            $table->string('kategori')->nullable();
            $table->string('skala_usaha')->nullable();
            $table->integer('tahun_berdiri')->nullable();
            $table->string('jumlah_karyawan')->nullable();

            // Branding & Visual
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('galeri')->nullable(); // JSON loaded

            // Verifikasi Detail
            $table->string('npwp')->nullable();
            $table->string('nama_penanggung_jawab')->nullable();
            $table->string('jabatan_penanggung_jawab')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm', function (Blueprint $table) {
            $table->dropColumn([
                'kategori',
                'skala_usaha',
                'tahun_berdiri',
                'jumlah_karyawan',
                'instagram',
                'tiktok',
                'whatsapp',
                'galeri',
                'npwp',
                'nama_penanggung_jawab',
                'jabatan_penanggung_jawab'
            ]);
        });
    }
};
