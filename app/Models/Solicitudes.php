<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    protected $fillable = [
        'tipo',
        'actividad',
        'razon',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
