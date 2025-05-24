<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialDivisas extends Model
{
    protected $fillable = [
        'cuentaDebitada',
        'cuentaDepositada',
        'venta',
        'monedaVenta',
        'compra',
        'monedaCompra',
        'concepto',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
