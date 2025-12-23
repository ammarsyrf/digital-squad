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
        Schema::table('hasil_tes', function (Blueprint $table) {
            if (!Schema::hasColumn('hasil_tes', 'total_soal')) {
                $table->integer('total_soal')->after('skor')->nullable();
            }
            if (!Schema::hasColumn('hasil_tes', 'jawaban_benar')) {
                $table->integer('jawaban_benar')->after('total_soal')->nullable();
            }
            if (!Schema::hasColumn('hasil_tes', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_tes', function (Blueprint $table) {
            $table->dropColumn(['total_soal', 'jawaban_benar', 'created_at', 'updated_at']);
        });
    }
};
