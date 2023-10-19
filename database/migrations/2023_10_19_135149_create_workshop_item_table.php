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
        Schema::create('workshop_item', function (Blueprint $table) {
            $table->id();
            $table->index('reservation_id');
            $table->string('nama');
            $table->integer('jumlah');
            $table->timestamps();
            $table->foreignId('reservation_id')->constrained('reservation')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshop_item');
    }
};
