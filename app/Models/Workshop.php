<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    protected $table = 'workshop';
    protected $fillable = [
        'nama',
        'gambar',
        'tgl_mulai',
        'tgl_selesai',
        'lat',
        'lng',
    ];

    public function paket()
    {
        return $this->hasMany(Paket::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function peserta()
    {
        return $this->hasManyThrough(Peserta::class, Transaction::class);
    }
}
