<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'opened_at',
        'closed_at',
        'opened_by',
        'closed_by',
        'status',
        'initial_amount', // New field for initial amount
    ];
}
