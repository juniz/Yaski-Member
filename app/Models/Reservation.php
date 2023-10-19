<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservation';
    protected $fillable = [
        'tgl_reservasi',
        'status',
        'tgl_confirm',
        'user_id',
        'workshop_id',
        'file_bukti'
    ];
}
