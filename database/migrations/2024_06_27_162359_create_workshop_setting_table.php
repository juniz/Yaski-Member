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
        Schema::create('workshop_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_id')->constrained('workshop')->onDelete('cascade');
            $table->text('deskripsi');
            $table->string('file_template', 150);
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
        Schema::dropIfExists('workshop_setting');
    }
};
