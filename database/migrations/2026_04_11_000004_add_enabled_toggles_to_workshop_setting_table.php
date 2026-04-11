<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshop_setting', function (Blueprint $table) {
            if (!Schema::hasColumn('workshop_setting', 'nama_enabled')) {
                $table->boolean('nama_enabled')->default(true)->after('nama_color');
            }
            if (!Schema::hasColumn('workshop_setting', 'no_sertifikat_enabled')) {
                $table->boolean('no_sertifikat_enabled')->default(true)->after('no_sertifikat_color');
            }
            if (!Schema::hasColumn('workshop_setting', 'instansi_enabled')) {
                $table->boolean('instansi_enabled')->default(true)->after('instansi_color');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshop_setting', function (Blueprint $table) {
            $table->dropColumn(['nama_enabled', 'no_sertifikat_enabled', 'instansi_enabled']);
        });
    }
};
