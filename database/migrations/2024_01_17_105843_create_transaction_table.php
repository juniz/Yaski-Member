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
        Schema::create('transaction', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->index('workshop_id');
            $table->string('snap_token');
            $table->string('nama', 100);
            $table->enum('jns_kelamin', ['L', 'P']);
            $table->string('email', 100);
            $table->string('telp', 20);
            $table->string('nama_rs', 100);
            $table->string('kd_rs', 20);
            $table->enum('kepemilikan_rs', ['Pemerintah', 'Swasta']);
            $table->index('provinsi_id');
            $table->index('kabupaten_id');
            $table->enum('ukuran_baju', ['S', 'M', 'L', 'XL', 'XXL']);
            $table->string('paket', 100);
            $table->string('harga', 100);
            $table->enum('stts', ['hadir', 'tidak_hadir'])->default('tidak_hadir');
            $table->timestamps();
            $table->foreignId('workshop_id')->constrained('workshop')->onDelete('cascade');
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
        Schema::dropIfExists('transaction');
    }
};
