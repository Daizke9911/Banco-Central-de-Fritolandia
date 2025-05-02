<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
        $userId = $this->route('usuario');
        
        $user = User::find($userId);

        return [
            'name' => 'required|min:4|max:100',
            'username' => 'required|min:6|max:100',
            'cedula' => 'required|numeric|min:100000|max:99999999|unique:users,cedula,'.$user->id,
            'phone' => 'required|numeric|min:1000000000|max:99999999999|unique:users,phone,'.$user->id,
            'nacimiento' => 'required|date',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ];
    }
    public function messages()
    {
        return[
            'cedula.min' => 'La cantidad minima de la cedula es del 7 digitos',
            'cedula.max' => 'La cantidad maxima de la cedula es de 8 digitos',
            'phone.min' => 'La cantidad minima del número telefonico es del 11 digitos',
            'phone.max' => 'La cantidad maxima del número telefonico es del 11 digitos'
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
