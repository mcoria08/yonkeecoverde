<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_unidad',
        'id_pieza',
        'part_name',
        'part_number',
        'manufacturer',
        'car_brand',
        'car_model_compatibility',
        'year_of_manufacture',
        'purchase_price',
        'selling_price',
        'location_in_stock',
        'condition',
        'notes',
    ];

}
