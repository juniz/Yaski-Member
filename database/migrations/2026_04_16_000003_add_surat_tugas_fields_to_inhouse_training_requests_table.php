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
        Schema::table('inhouse_training_requests', function (Blueprint $table) {
            $table->string('file_tugas', 100)->nullable()->after('file_balasan');
            $table->json('data_surat')->nullable()->after('alasan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inhouse_training_requests', function (Blueprint $table) {
            $table->dropColumn(['file_tugas', 'data_surat']);
        });
    }
};
