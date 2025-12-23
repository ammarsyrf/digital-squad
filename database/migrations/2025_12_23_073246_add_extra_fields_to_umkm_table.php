<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('umkm', function (Blueprint $table) {
            if (!Schema::hasColumn('umkm', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('nama_umkm');
            }
            if (!Schema::hasColumn('umkm', 'telepon')) {
                $table->string('telepon')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('umkm', 'email_instansi')) {
                $table->string('email_instansi')->nullable()->after('telepon');
            }
            if (!Schema::hasColumn('umkm', 'website')) {
                $table->string('website')->nullable()->after('email_instansi');
            }
            if (!Schema::hasColumn('umkm', 'logo')) {
                $table->string('logo')->nullable()->after('website');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'telepon', 'email_instansi', 'website', 'logo']);
        });
    }
};
