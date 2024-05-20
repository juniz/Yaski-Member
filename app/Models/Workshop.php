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
        'slug',
        'gambar',
        'tor',
        'tgl_sampai',
        'tgl_mulai',
        'tgl_selesai',
        'lat',
        'lng',
        'stts',
    ];

    public function paket()
    {
        return $this->hasMany(Paket::class, 'workshop_id', 'id');
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
