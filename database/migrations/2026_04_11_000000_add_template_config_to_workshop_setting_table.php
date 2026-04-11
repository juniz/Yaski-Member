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
        if (!Schema::hasTable('workshop_setting')) {
            // Create table jika belum ada
            Schema::create('workshop_setting', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('workshop_id');
                $table->text('deskripsi')->nullable();
                $table->string('file_template', 150)->nullable();

                // Posisi dan style untuk Nama peserta
                $table->integer('nama_x')->default(500);
                $table->integer('nama_y')->default(400);
                $table->integer('nama_font_size')->default(40);
                $table->string('nama_color', 7)->default('#000000');

                // Posisi dan style untuk No Sertifikat
                $table->integer('no_sertifikat_x')->default(500);
                $table->integer('no_sertifikat_y')->default(350);
                $table->integer('no_sertifikat_font_size')->default(20);
                $table->string('no_sertifikat_color', 7)->default('#333333');

                // Posisi dan style untuk Instansi
                $table->integer('instansi_x')->default(500);
                $table->integer('instansi_y')->default(460);
                $table->integer('instansi_font_size')->default(24);
                $table->string('instansi_color', 7)->default('#333333');

                // Posisi dan ukuran QR Code
                $table->integer('qr_x')->default(900);
                $table->integer('qr_y')->default(500);
                $table->integer('qr_size')->default(150);
                $table->boolean('qr_enabled')->default(true);

                $table->timestamps();
            });
        } else {
            // Alter table jika sudah ada (tambah kolom baru)
            Schema::table('workshop_setting', function (Blueprint $table) {
                if (!Schema::hasColumn('workshop_setting', 'nama_x')) {
                    $table->integer('nama_x')->default(500)->after('file_template');
                    $table->integer('nama_y')->default(400)->after('nama_x');
                    $table->integer('nama_font_size')->default(40)->after('nama_y');
                    $table->string('nama_color', 7)->default('#000000')->after('nama_font_size');

                    $table->integer('no_sertifikat_x')->default(500)->after('nama_color');
                    $table->integer('no_sertifikat_y')->default(350)->after('no_sertifikat_x');
                    $table->integer('no_sertifikat_font_size')->default(20)->after('no_sertifikat_y');
                    $table->string('no_sertifikat_color', 7)->default('#333333')->after('no_sertifikat_font_size');

                    $table->integer('instansi_x')->default(500)->after('no_sertifikat_color');
                    $table->integer('instansi_y')->default(460)->after('instansi_x');
                    $table->integer('instansi_font_size')->default(24)->after('instansi_y');
                    $table->string('instansi_color', 7)->default('#333333')->after('instansi_font_size');
                }

                if (!Schema::hasColumn('workshop_setting', 'qr_x')) {
                    $table->integer('qr_x')->default(900)->after('instansi_color');
                    $table->integer('qr_y')->default(500)->after('qr_x');
                    $table->integer('qr_size')->default(150)->after('qr_y');
                    $table->boolean('qr_enabled')->default(true)->after('qr_size');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('workshop_setting')) {
            Schema::table('workshop_setting', function (Blueprint $table) {
                $columns = [
                    'nama_x', 'nama_y', 'nama_font_size', 'nama_color',
                    'no_sertifikat_x', 'no_sertifikat_y', 'no_sertifikat_font_size', 'no_sertifikat_color',
                    'instansi_x', 'instansi_y', 'instansi_font_size', 'instansi_color',
                    'qr_x', 'qr_y', 'qr_size', 'qr_enabled',
                ];
                $existing = [];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('workshop_setting', $col)) {
                        $existing[] = $col;
                    }
                }
                if (!empty($existing)) {
                    $table->dropColumn($existing);
                }
            });
        }
    }
};
