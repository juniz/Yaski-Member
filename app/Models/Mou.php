<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mou extends Model
{
    use HasFactory;

    protected $table = "mou";

    protected $fillable = [
        'user_id',
        'no_surat',
        'tgl_surat',
        'file_pertama',
        'file_kedua',
        'alasan',
        'stts',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
