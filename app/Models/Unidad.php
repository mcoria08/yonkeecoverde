<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Unidad extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    public $fillable = ['proviene', 'datos', 'unidad', 'marca', 'modelo', 'anio', 'detalles', 'motor', 'observaciones'];
}
