<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = "peserta";

    protected $fillable = [
        'nama',
        'jns_kelamin',
        'email',
        'telp',
        'transaction_id',
        'baju',
        'paket',
        'harga',
        'stts',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getJnsKelaminAttribute($value)
    {
        return $value == 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
