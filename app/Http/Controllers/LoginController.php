<?php

namespace App\Http\Controllers;

use App\Models\Cuentas;
use App\Models\Roles;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class LoginController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'. User::class],
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
            'password' => ['required', 'string', 'confirmed'],
            'cuentaType' => ['required']
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->username = $request->username;
        $user->cedula = $request->cedula;
        $user->phone = $request->phone;
        $user->nacimiento = $request->nacimiento;
        $user->email = $request->email;
        $user->role = "user";
        $user->pregunta_1 = $request->pregunta_1;
        $user->respuesta_1 = Hash::make($request->respuesta_1);
        $user->pregunta_2 = $request->pregunta_2;
        $user->respuesta_2 = Hash::make($request->respuesta_2);
        $user->pregunta_3 = $request->pregunta_3;
        $user->respuesta_3 = Hash::make($request->respuesta_3);
        $user->password = Hash::make($request->password);

        $user->save();

        $cuenta = new Cuentas();
        $i=1;
            do{
                $number= 9911000000 + $i;
                $verificarCuenta = Cuentas::where('accountNumber',$number)->first();
                if(empty($verificarCuenta->accountNumber)){
                    $cuenta->accountNumber = $number;
                    $cuenta->cuentaType = $request['cuentaType'];
                    $number = 111;
                }else{
                    $i++;
                }
            }while($number != 111);
        $user->cuenta()->save($cuenta); //crear cuenta

        $tema = new Tema();
        $tema->sidebar = "#343a40";
        $tema->button_sidebar = "#007bff";
        $tema->text_color_sidebar = "#fff";
        $tema->background = "";
        $user->tema()->save($tema);

        event(new Registered($user));
        
        return redirect(route('login'));
    }

    public function login(Request $request){
        $credentials = [
            "username" => $request->username,
            "password" => $request->password
        ];

        $remember = ($request->has('remember') ? true : false);

        if(Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }else{
            return redirect(route('login'));
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}