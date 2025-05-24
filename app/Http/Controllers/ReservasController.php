<?php

namespace App\Http\Controllers;

use App\Models\Monedas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ReservasController extends Controller
{
    public function index(){

        if(Auth::user()->role === "admin" || Auth::user()->id === 1){

            $reservas = Monedas::all();
            return view('vistas.index_reservas', compact('reservas'));
        }else{
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        
    }

    public function update(Request $request, $id){
        
        if(Auth::user()->role === "admin" || Auth::user()->id === 1){
            $request->validate([
                'reserva' => 'required|numeric',
                'password' => 'required|string|max:255'
            ]);

            if(Hash::check($request->password, Auth::user()->password)){
                $reserva = Monedas::where('id', $id)->first();
                $reserva->reserva = $request->reserva;
                $reserva->save();
                return redirect(route('reservas.index'))->with('message', 'Cambio exitoso!.');
            }else{
                return back()->with('error', 'Contraseña Incorrecta');
            }
            
        }else{
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }
    }
}
