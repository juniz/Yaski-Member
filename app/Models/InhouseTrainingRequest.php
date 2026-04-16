<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InhouseTrainingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_kegiatan',
        'no_surat',
        'tgl_surat',
        'file',
        'file_balasan',
        'file_tugas',
        'stts',
        'alasan',
        'data_surat',
    ];

    protected $casts = [
        'data_surat' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
