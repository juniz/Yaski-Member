<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopItem extends Model
{
    use HasFactory;
    protected $table = 'workshop_item';
    protected $fillable = [
        'nama',
        'jumlah',
        'reservation_id',
        'harga',
    ];
}
