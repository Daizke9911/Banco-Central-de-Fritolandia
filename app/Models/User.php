<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'cedula',
        'phone',
        'nacimiento',
        'email',
        'pregunta_1',
        'respuesta_1',
        'pregunta_2',
        'respuesta_2',
        'pregunta_3',
        'respuesta_3',
        'imagenPerfil',
        'imagenCedula',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cuenta(){
        return $this->hasMany(Cuentas::class);
    }

    public function tema(): HasOne
    {
        return $this->hasOne(Tema::class);
    }

    public function solicitud(): HasOne
    {
        return $this->hasOne(Solicitudes::class);
    }

    public function buzon(){
        return $this->hasMany(Buzon::class);
    }

    public function historialDivisa(){
        return $this->hasMany(HistorialDivisas::class);
    }
}
