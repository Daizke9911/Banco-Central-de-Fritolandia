<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monedas extends Model
{
    protected $fillable = [
        'moneda',
        'reserva',
        'precio'
    ];
}
