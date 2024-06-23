<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Sertifikat extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sertifikat';
    protected $fillable = [
        'peserta_id',
        'workshop_id',
        'no_urut',
        'no_sertifikat',
        'nama',
        'instansi',
        'file_sertifikat',
    ];
}
