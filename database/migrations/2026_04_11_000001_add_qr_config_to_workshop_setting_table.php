<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('workshop_setting', function (Blueprint $table) {
            if (!Schema::hasColumn('workshop_setting', 'qr_x')) {
                $table->integer('qr_x')->default(900)->after('instansi_color');
                $table->integer('qr_y')->default(500)->after('qr_x');
                $table->integer('qr_size')->default(150)->after('qr_y');
                $table->boolean('qr_enabled')->default(true)->after('qr_size');
            }
        });
    }

    public function down()
    {
        Schema::table('workshop_setting', function (Blueprint $table) {
            $cols = ['qr_x', 'qr_y', 'qr_size', 'qr_enabled'];
            $existing = [];
            foreach ($cols as $col) {
                if (Schema::hasColumn('workshop_setting', $col)) {
                    $existing[] = $col;
                }
            }
            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};
