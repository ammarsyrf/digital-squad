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
        Schema::table('soal_skill', function (Blueprint $table) {
            // Modify 'kesulitan' to be an enum or string large enough
            // Since we can't easily change to enum if data exists without mapping,
            // we'll change it to string first or try to change definition.
            // Using DB::statement to alter might be safer for enums in MySQL.

            $table->string('kesulitan', 20)->change();
            $table->string('status', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal_skill', function (Blueprint $table) {
            //
        });
    }
};
