<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasyankes extends Model
{
    use HasFactory;

    public function belongUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Regency::class, 'kabupaten_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'provinsi_id');
    }
}
