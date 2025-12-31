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
        Schema::table('soal_skill', function (Blueprint $table) {
            $table->enum('tipe_soal', ['pilihan_ganda', 'essay'])->default('pilihan_ganda')->after('kategori_id');
            $table->text('kunci_jawaban_essay')->nullable()->after('jawaban_benar');
            
            // Make these nullable
            $table->string('opsi_a')->nullable()->change();
            $table->string('opsi_b')->nullable()->change();
            $table->string('opsi_c')->nullable()->change();
            $table->string('opsi_d')->nullable()->change();
            $table->enum('jawaban_benar', ['A', 'B', 'C', 'D'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal_skill', function (Blueprint $table) {
            $table->dropColumn('tipe_soal');
            $table->dropColumn('kunci_jawaban_essay');

            // Revert validation changes (careful if data exists with nulls)
            // Ideally we just make them nullable permanently or fill them before reverting, 
            // but for down() strictly:
            $table->string('opsi_a')->nullable(false)->change();
            $table->string('opsi_b')->nullable(false)->change();
            $table->string('opsi_c')->nullable(false)->change();
            $table->string('opsi_d')->nullable(false)->change();
            // Note: Reverting enum change might be tricky if it was just enum before 
            // but `change()` requires doctrine/dbal. 
            // Assuming this is fine for dev environment.
        });
    }
};
