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
        Schema::create('inhouse_training_requests', function (Blueprint $table) {
            $table->id();
            $table->index('user_id');
            $table->string('no_surat', 100);
            $table->date('tgl_surat');
            $table->string('file', 100);
            $table->enum('stts', ['proses', 'disetujui', 'ditolak'])->default('proses');
            $table->text('alasan')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inhouse_training_requests');
    }
};
