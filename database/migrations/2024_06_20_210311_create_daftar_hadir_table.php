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
        Schema::create('daftar_hadir', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('workshop_id')->constrained('workshop')->onDelete('cascade');
            $table->enum('stts', ['Hadir', 'Tidak Hadir', 'Tidak Hadir']);
            $table->text('keterangan')->nullable();
            $table->dateTime('tgl_hadir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daftar_hadir');
    }
};
