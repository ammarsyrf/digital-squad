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
        // 1. Drop Foreign Keys
        // We use the array syntax for dropForeign to let Laravel infer the key name
        if (Schema::hasTable('admin')) {
            Schema::table('admin', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }
        if (Schema::hasTable('umkm')) {
            Schema::table('umkm', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }
        if (Schema::hasTable('talent')) {
            Schema::table('talent', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }
        if (Schema::hasTable('sertifikat')) {
            Schema::table('sertifikat', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }
        if (Schema::hasTable('pesan')) {
            Schema::table('pesan', function (Blueprint $table) {
                $table->dropForeign(['sender_id']);
                $table->dropForeign(['receiver_id']);
            });
        }
        if (Schema::hasTable('notifikasi')) {
            Schema::table('notifikasi', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }
        if (Schema::hasTable('hasil_tes')) {
            Schema::table('hasil_tes', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['kategori_id']);
            });
        }
        if (Schema::hasTable('soal_skill')) {
            Schema::table('soal_skill', function (Blueprint $table) {
                $table->dropForeign(['kategori_id']);
            });
        }
        if (Schema::hasTable('lowongan')) {
            Schema::table('lowongan', function (Blueprint $table) {
                $table->dropForeign(['umkm_id']);
            });
        }
        if (Schema::hasTable('lamaran')) {
            Schema::table('lamaran', function (Blueprint $table) {
                $table->dropForeign(['talent_id']);
                $table->dropForeign(['lowongan_id']);
            });
        }

        // 2. Rename Primary Keys
        $tables = [
            'users' => 'id_users',
            'admin' => 'id_admin',
            'umkm' => 'id_umkm',
            'talent' => 'id_talent',
            'kategori_skill' => 'id_kategori_skill',
            'soal_skill' => 'id_soal_skill',
            'lowongan' => 'id_lowongan',
            'lamaran' => 'id_lamaran',
            'sertifikat' => 'id_sertifikat',
            'pesan' => 'id_pesan',
            'notifikasi' => 'id_notifikasi',
            'hasil_tes' => 'id_hasil_tes',
        ];

        foreach ($tables as $table => $newId) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $tableObj) use ($newId) {
                    $tableObj->renameColumn('id', $newId);
                });
            }
        }

        // 3. Re-add Foreign Keys
        if (Schema::hasTable('admin')) {
            Schema::table('admin', function (Blueprint $table) {
                $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('umkm')) {
            Schema::table('umkm', function (Blueprint $table) {
                $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('talent')) {
            Schema::table('talent', function (Blueprint $table) {
                $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('sertifikat')) {
            Schema::table('sertifikat', function (Blueprint $table) {
                $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('pesan')) {
            Schema::table('pesan', function (Blueprint $table) {
                $table->foreign('sender_id')->references('id_users')->on('users')->onDelete('cascade');
                $table->foreign('receiver_id')->references('id_users')->on('users')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('notifikasi')) {
            Schema::table('notifikasi', function (Blueprint $table) {
                $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('soal_skill')) {
            Schema::table('soal_skill', function (Blueprint $table) {
                $table->foreign('kategori_id')->references('id_kategori_skill')->on('kategori_skill')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('lowongan')) {
            Schema::table('lowongan', function (Blueprint $table) {
                $table->foreign('umkm_id')->references('id_umkm')->on('umkm')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('lamaran')) {
            Schema::table('lamaran', function (Blueprint $table) {
                $table->foreign('talent_id')->references('id_talent')->on('talent')->onDelete('cascade');
                $table->foreign('lowongan_id')->references('id_lowongan')->on('lowongan')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('hasil_tes')) {
            Schema::table('hasil_tes', function (Blueprint $table) {
                $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');
                $table->foreign('kategori_id')->references('id_kategori_skill')->on('kategori_skill')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // To reverse this, we'd need to do the exact opposite. 
         // For now, focusing on Up as per request.
    }
};
