<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tema extends Model
{
    protected $fillable = [
        'user_id',
        'sidebar',
        'button_sidebar',
        'text_color_sidebar',
        'background'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}
