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
        Schema::create('fasyankes', function (Blueprint $table) {
            $table->id();
            $table->index('user_id');
            $table->string('kode');
            $table->string('nama');
            $table->string('jenis');
            $table->string('kelas');
            $table->string('telp');
            $table->string('email');
            $table->string('direktur');
            $table->string('alamat');
            $table->index('provinsi_id');
            $table->index('kabupaten_id');
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('provinsi_id')->constrained('provinces')->onDelete('cascade');
            $table->foreignId('kabupaten_id')->constrained('regencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fasyankes');
    }
};
