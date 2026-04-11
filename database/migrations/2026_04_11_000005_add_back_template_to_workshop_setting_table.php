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
        Schema::table('workshop_setting', function (Blueprint $col) {
            if (!Schema::hasColumn('workshop_setting', 'file_template_belakang')) {
                $col->string('file_template_belakang')->nullable()->after('file_template');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshop_setting', function (Blueprint $col) {
            if (Schema::hasColumn('workshop_setting', 'file_template_belakang')) {
                $col->dropColumn('file_template_belakang');
            }
        });
    }
};
