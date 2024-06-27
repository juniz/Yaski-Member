<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopSetting extends Model
{
    use HasFactory;

    protected $table = 'workshop_setting';
    protected $fillable = ['workshop_id', 'deskripsi', 'file_template'];
}
