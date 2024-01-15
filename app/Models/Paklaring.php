<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paklaring extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file',
        'stts',
        'no_surat',
        'tgl_pakai',
        'file_verif',
        'alasan'
    ];
    public function fasyankes()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
