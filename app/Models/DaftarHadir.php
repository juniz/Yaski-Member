<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarHadir extends Model
{
    use HasFactory;

    protected $table = "daftar_hadir";
    protected $fillable = [
        'user_id',
        'workshop_id',
        'tgl_daftar',
        'stts',
    ];
}
