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
        Schema::table('sertifikat', function (Blueprint $table) {
            if (!Schema::hasColumn('sertifikat', 'file_sertifikat_belakang')) {
                $table->string('file_sertifikat_belakang', 100)->nullable()->after('file_sertifikat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            if (Schema::hasColumn('sertifikat', 'file_sertifikat_belakang')) {
                $table->dropColumn('file_sertifikat_belakang');
            }
        });
    }
};
