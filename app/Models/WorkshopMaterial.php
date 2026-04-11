<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopMaterial extends Model
{
    use HasFactory;

    protected $table = 'workshop_materials';

    protected $fillable = [
        'workshop_id',
        'title',
        'description',
        'file_path',
        'link_url',
        'type',
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
