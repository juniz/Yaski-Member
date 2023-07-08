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
}
