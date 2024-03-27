<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $table = "transaction";
    protected $fillable = [
        'workshop_id',
        'snap_token',
        'order_id',
        // 'nama',
        // 'jns_kelamin',
        // 'email',
        // 'telp',
        'nama_rs',
        'kd_rs',
        'kepemilikan_rs',
        'provinsi_id',
        'kabupaten_id',
        // 'ukuran_baju',
        // 'paket',
        // 'harga',
        'stts',
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Province::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Regency::class);
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }
}
