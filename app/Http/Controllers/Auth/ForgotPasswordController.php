<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function vista_verificar_usuario()
    {
        return view('recuperar_contrasena.verificar_usuario');
    }

    public function verificar_usuario(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'cedula' => 'required|string',
        ]);

        $user = User::where('username', $request->username)
                    ->where('cedula', $request->cedula)
                    ->first();

        if (!$user) {
            return back()->withErrors(['credentials' => 'El usuario no existe o los datos estan erroneos'])->withInput();
        }

        // Almacenar el ID del usuario en la sesión para los siguientes pasos
        session(['password_recover_user_id' => $user->id]);

        return redirect()->route('vista_preguntas_seguridad');
    }

    public function vista_preguntas_seguridad()
    {
        if (!session()->has('password_recover_user_id')) {
            return redirect()->route('vista_verificar_usuario')->withErrors(['expired' => 'La sesión de recuperación de contraseña ha expirado. Por favor, inténtalo de nuevo.']);
        }

        $user = User::findOrFail(session('password_recover_user_id')); 

        return view('recuperar_contrasena.preguntas_seguridad', compact('user'));
    }

    public function verificar_preguntas_seguridad(Request $request)
    {
        // Verificar si el ID del usuario está en la sesión
        if (!session()->has('password_recover_user_id')) {
            return redirect()->route('vista_verificar_usuario')->withErrors(['expired' => 'La sesión de recuperación de contraseña ha expirado. Por favor, inténtalo de nuevo.']);
        }

        $user = User::findOrFail(session('password_recover_user_id'));

        if(Hash::check($request->respuesta_1, $user->respuesta_1)){
            if(Hash::check($request->respuesta_2, $user->respuesta_2)){
                if(Hash::check($request->respuesta_3, $user->respuesta_3)){
                    return redirect()->route('vista_cambiar_contrasena');
                }else{
                    return back()->withErrors(['security' => 'Las respuestas 3 de seguridad es incorrecta.'])->withInput();
                }
            }else{
                return back()->withErrors(['security' => 'Las respuestas 2 de seguridad es incorrecta.'])->withInput();
            }
        }else{
            return back()->withErrors(['security' => 'Las respuestas 1 de seguridad es incorrecta.'])->withInput();
        }
        
    }

    public function vista_cambiar_contrasena()
    {
        // Verificar si el ID del usuario está en la sesión
        if (!session()->has('password_recover_user_id')) {
            return redirect()->route('password.recover.username')->withErrors(['expired' => 'La sesión de recuperación de contraseña ha expirado. Por favor, inténtalo de nuevo.']);
        }

        return view('recuperar_contrasena.cambiar_contrasena');
    }

    public function verificar_cambiar_contrasena(Request $request)
    {
        // Verificar si el ID del usuario está en la sesión
        if (!session()->has('password_recover_user_id')) {
            return redirect()->route('vista_verificar_usuario')->withErrors(['expired' => 'La sesión de recuperación de contraseña ha expirado. Por favor, inténtalo de nuevo.']);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail(session('password_recover_user_id'));
        $user->password = Hash::make($request->password);
        $user->save();

        // Limpiar la sesión
        session()->forget('password_recover_user_id');

        return redirect()->route('login')->with('success', 'Tu contraseña ha sido restablecida exitosamente. Por favor, inicia sesión.');
    }
}