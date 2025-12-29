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
        // 1. Users Table
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                // 'name' will be added by add_name_to_users_table migration if strictly following order,
                // but for a base table it's safer to include it if we want a working system immediately.
                // However, add_name_to_users_table expects it NOT to be there (fails if duplicate column? default mysql allows? no).
                // Let's omit 'name' and 'status' to let the other migrations run.
                // UPDATE: add_name_to_users_table uses Schema::table with ->after('id').
                // If I omit it, the migration works.
                $table->string('email')->unique();
                $table->string('password');
                $table->string('role')->nullable(); // nullable just in case
                $table->timestamps(); // creates created_at and updated_at
                // adapt_native_tables adds email_verified_at, remember_token.
                // We'll leave them out.
            });
        }

        // 2. Admin Table
        if (!Schema::hasTable('admin')) {
            Schema::create('admin', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('nama_admin');
                // No timestamps per model
            });
        }

        // 3. Umkm Table
        if (!Schema::hasTable('umkm')) {
            Schema::create('umkm', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('nama_perusahaan')->nullable();
                $table->string('nama_umkm')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('alamat')->nullable();
                $table->string('telepon')->nullable();
                $table->string('email_instansi')->nullable();
                $table->string('website')->nullable();
                $table->string('logo')->nullable();
                $table->string('status_verifikasi')->default('pending');
                $table->text('catatan_admin')->nullable();
                $table->timestamps();
            });
        }

        // 4. Talent Table
        if (!Schema::hasTable('talent')) {
            Schema::create('talent', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('nama_lengkap')->nullable();
                $table->text('deskripsi')->nullable();
                $table->date('tanggal_lahir')->nullable();
                $table->integer('umur')->nullable();
                $table->string('jenis_kelamin')->nullable();
                $table->string('status_pernikahan')->nullable();
                $table->text('alamat')->nullable();
                $table->string('telepon')->nullable();
                $table->text('hobi')->nullable();
                $table->string('pekerjaan_saat_ini')->nullable();
                $table->text('pengalaman_kerja')->nullable();
                $table->string('pendidikan_terakhir')->nullable();
                $table->text('skill')->nullable();
                $table->string('linkedin')->nullable();
                $table->string('portfolio')->nullable();
                $table->string('foto')->nullable();
                // No timestamps per model
            });
        }

        // 5. Kategori Skill Table
        if (!Schema::hasTable('kategori_skill')) {
            Schema::create('kategori_skill', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kategori');
                // No timestamps per model
            });
        }

        // 6. Soal Skill Table
        if (!Schema::hasTable('soal_skill')) {
            Schema::create('soal_skill', function (Blueprint $table) {
                $table->id();
                $table->foreignId('kategori_id')->constrained('kategori_skill')->onDelete('cascade');
                $table->text('pertanyaan');
                $table->string('opsi_a')->nullable();
                $table->string('opsi_b')->nullable();
                $table->string('opsi_c')->nullable();
                $table->string('opsi_d')->nullable();
                $table->string('jawaban_benar')->nullable();
                $table->string('kesulitan')->nullable();
                $table->string('status')->default('active');
                $table->timestamps();
            });
        }

        // 7. Lowongan Table
        if (!Schema::hasTable('lowongan')) {
            Schema::create('lowongan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('umkm_id')->constrained('umkm')->onDelete('cascade');
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->string('tipe_pekerjaan')->nullable();
                $table->string('lokasi')->nullable();
                $table->string('gaji')->nullable();
                $table->string('status')->default('open');
                $table->timestamps();
            });
        }

        // 8. Lamaran Table
        if (!Schema::hasTable('lamaran')) {
            Schema::create('lamaran', function (Blueprint $table) {
                $table->id();
                $table->foreignId('talent_id')->constrained('talent')->onDelete('cascade');
                $table->foreignId('lowongan_id')->constrained('lowongan')->onDelete('cascade');
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }

        // 9. Sertifikat Table
        if (!Schema::hasTable('sertifikat')) {
            Schema::create('sertifikat', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('nama_sertifikat');
                $table->string('penerbit')->nullable();
                $table->date('tanggal_terbit')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('file_path')->nullable();
                $table->string('status')->default('valid');
                $table->timestamps();
            });
        }

        // 10. Pesan Table
        if (!Schema::hasTable('pesan')) {
            Schema::create('pesan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
                $table->text('pesan');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }

        // 11. Notifikasi Table
        if (!Schema::hasTable('notifikasi')) {
            Schema::create('notifikasi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('judul');
                $table->text('pesan')->nullable();
                $table->string('link')->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop in reverse order of dependencies
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('pesan');
        Schema::dropIfExists('sertifikat');
        Schema::dropIfExists('lamaran');
        Schema::dropIfExists('lowongan');
        Schema::dropIfExists('soal_skill');
        Schema::dropIfExists('kategori_skill');
        Schema::dropIfExists('talent');
        Schema::dropIfExists('umkm');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('users');
    }
};
