<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopSetting extends Model
{
    use HasFactory;

    protected $table = 'workshop_setting';
    protected $fillable = [
        'workshop_id',
        'deskripsi',
        'file_template',
        'nama_x',
        'nama_y',
        'nama_font_size',
        'nama_color',
        'no_sertifikat_x',
        'no_sertifikat_y',
        'no_sertifikat_font_size',
        'no_sertifikat_color',
        'instansi_x',
        'instansi_y',
        'instansi_font_size',
        'instansi_color',
        'nama_enabled',
        'no_sertifikat_enabled',
        'instansi_enabled',
        'qr_x',
        'qr_y',
        'qr_size',
        'qr_enabled',
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
