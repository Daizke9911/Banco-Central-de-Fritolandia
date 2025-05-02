<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:255'],
            'username' => ['required', 'string', 'min:6','max:255', 'unique:'. User::class],
            'cedula' => ['required', 'numeric', 'min:1000000', 'max:99999999', 'unique:'. User::class],
            'phone' => ['required', 'numeric', 'min:10000000000', 'max:99999999999', 'unique:'.User::class],
            'nacimiento' => ['required', 'date'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'pregunta_1' => ['required', 'string', 'max:255'],
            'respuesta_1' => ['required', 'string', 'max:255'],
            'pregunta_2' => ['required', 'string', 'max:255'],
            'respuesta_2' => ['required', 'string', 'max:255'],
            'pregunta_3' => ['required', 'string', 'max:255'],
            'respuesta_3' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'cuentaType' => ['required']
        ];
    }
    public function messages()
    {
        return[
            'cedula.min' => 'La cantidad minima es del 7 digitos',
            'cedula.max' => 'La cantidad maxima es de 8 digitos',
            'phone.min' => 'La cantidad minima es del 11 digitos',
            'phone.max' => 'La cantidad maxima es de 11 digitos'
        ];
    }
    public function attributes()
    {
        return[
        'name' => 'Nombre',
        'phone' => 'Telefono',
        'money' => 'Dinero',
        'password' => 'contraseña',
        'cuentaType' => 'Cuenta Destino'
        
        ];
    }
    
}
