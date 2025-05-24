<?php

namespace App\Http\Controllers;

use App\Models\Buzon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuzonController extends Controller
{
    public function index(){
        $entradas = Buzon::where('user_id', Auth::user()->id)->where('ea', 1)
        ->orderBy('id', 'desc')
        ->paginate(3);

        $salidas = Buzon::where('user_id', Auth::user()->id)->where('ea', 2)
        ->orderBy('id', 'desc')
        ->paginate(3);

        return view('vistas.index_buzon', compact('entradas', 'salidas'));
    }

    public function show($id){
        $detalles = Buzon::find($id);

        return view('vistas.show_buzon', compact('detalles'));
    }
}
