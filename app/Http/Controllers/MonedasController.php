<?php

namespace App\Http\Controllers;

use App\Models\Cuentas;
use App\Models\HistorialDivisas;
use App\Models\Monedas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MonedasController extends Controller
{

    public function index(){

        //VERIFICA SI EL USUARIO TIENE CUENTA EN DOLARES
        $cuentasDolar = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'dolar')->get();

        $i = 0;
        foreach($cuentasDolar as $cuentaDolar){
            $i++;
        }

        if($i == 0){
            abort(403, 'No tiene cuentas en dolares, aperture una cuenta.');
        }

        $historials = HistorialDivisas::where('user_id',Auth::user()->id)
        ->orderBy('id', 'desc')
        ->paginate(3);

        

        foreach($historials as $historial){
            $historial->monedaVenta = ucfirst($historial->monedaVenta);
            $historial->monedaCompra = ucfirst($historial->monedaCompra);
        }

        return view('vistas.index_historial_divisas', compact('historials', 'i'));
    }

    public function create(){

        //VERIFICA SI EL USUARIO TIENE CUENTA EN DOLARES
        $cuentasDolar = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'dolar')->get();

        $i = 0;
        foreach($cuentasDolar as $cuentaDolar){
            $i++;
        }

        if($i == 0){
            abort(403, 'No tiene cuentas en dolares, aperture una cuenta.');
        }

        $cuentasLogin = Cuentas::where('user_id', Auth::user()->id)->where('moneda', 'nacional')->get();
        $monedas = Monedas::where('moneda', 'Dolar')->first();

        return view('vistas.create_compra_divisas', compact('cuentasLogin', 'monedas', 'i', 'cuentasDolar'));
    }

    public function store(Request $request){

        //VERIFICA SI EL USUARIO TIENE CUENTA EN DOLARES
        $cuentasDolar = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'dolar')->get();

        $i = 0;
        foreach($cuentasDolar as $cuentaDolar){
            $i++;
        }

        if($i == 0){
            abort(403, 'No tiene cuentas en dolares, aperture una cuenta.');
        }

        $request->validate([
            'cuentaTypeLogin' => 'required',
            'cuentaTypeDeposito' => 'required',
            'money' => 'required|numeric|min:1|max:10000',
            'concepto' => 'required|max:255',
            'password' => 'required|string|min:8|max:255'
        ],[
            'money.min' => 'La cantidad minima de compra es de 1$',
            'money.max' => 'La cantidad maxima de compra es de 10.000$'
        ]);

        $cuentaFritos = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'nacional')->where('cuentaType', $request->cuentaTypeLogin)->first();
        $cuentaDolar = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'dolar')->where('cuentaType', $request->cuentaTypeDeposito)->first();
        
        $monedas = Monedas::where('moneda', 'Dolar')->first();
        $monedasFritos = Monedas::where('moneda', 'Fritos')->first();

        if(Hash::check($request->password, Auth::user()->password)){
            if($request->money < $monedas->reserva){
                if($request->fritosTotal < $cuentaFritos->availableBalance){

                    $cuentaFritos->availableBalance = $cuentaFritos->availableBalance - $request->fritosTotal;
                    $cuentaDolar->availableBalance = $cuentaDolar->availableBalance + $request->money;
                    $monedas->reserva = $monedas->reserva - $request->money;
                    $monedasFritos->reserva = $monedasFritos->reserva + $request->fritosTotal;

                    $venta = $request->fritosTotal * -1;

                    $historial = new HistorialDivisas();
                    $historial->cuentaDebitada = $cuentaFritos->accountNumber;
                    $historial->cuentaDepositada = $cuentaDolar->accountNumber;
                    $historial->venta = $venta;
                    $historial->monedaVenta = 'fritos';
                    $historial->compra = $request->money;
                    $historial->monedaCompra = 'dolar';
                    $historial->concepto = $request->concepto;
                    $historial->user_id = Auth::user()->id;
                    
                    $historial->save();
                    $cuentaDolar->save();
                    $cuentaFritos->save();
                    $monedas->save();
                    $monedasFritos->save();

                    return redirect(route('monedas.index'))->with('message', 'Compra de Dolares Realizada!');

                }else{
                    return redirect(route('monedas.create'))->with('error', 'No tienes suficiente saldo en Fritos para esta operación.');
                }
            }else{
                return redirect(route('monedas.create'))->with('error', 'No hay reserva de divisa suficientes, intente más tarde.');
            }
        }else{
            return redirect(route('monedas.create'))->with('error', 'Contraseña Incorrecta');
        }

        return redirect(route('monedas.create'))->with('error', 'Ups, algo salio mal, intente de nuevo!');
    }

    public function show($historialId){

        //VERIFICA SI EL USUARIO TIENE CUENTA EN DOLARES
        $cuentasDolar = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'dolar')->get();

        $i = 0;
        foreach($cuentasDolar as $cuentaDolar){
            $i++;
        }

        if($i == 0){
            abort(403, 'No tiene cuentas en dolares, aperture una cuenta.');
        }

        $historial = HistorialDivisas::where('id', $historialId)->first();

        $historial->monedaVenta = ucfirst($historial->monedaVenta);
        $historial->monedaCompra = ucfirst($historial->monedaCompra);

        return view('vistas.show_historial_divisas', compact('historial'));
        
    }

    public function venta(){

        //VERIFICA SI EL USUARIO TIENE CUENTA EN DOLARES
        $cuentasDolar = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'dolar')->get();

        $i = 0;
        foreach($cuentasDolar as $cuentaDolar){
            $i++;
        }

        if($i == 0){
            abort(403, 'No tiene cuentas en dolares, aperture una cuenta.');
        }

        $cuentasLogin = Cuentas::where('user_id', Auth::user()->id)->where('moneda', 'nacional')->get();
        $monedas = Monedas::where('moneda', 'Dolar')->first();

        return view('vistas.create_venta_divisas', compact('cuentasLogin', 'monedas', 'i', 'cuentasDolar'));
    }

    public function ventaConfirm(Request $request){

        //VERIFICA SI EL USUARIO TIENE CUENTA EN DOLARES
        $cuentasDolar = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'dolar')->get();

        $i = 0;
        foreach($cuentasDolar as $cuentaDolar){
            $i++;
        }

        if($i == 0){
            abort(403, 'No tiene cuentas en dolares, aperture una cuenta.');
        }

        $request->validate([
            'cuentaTypeLogin' => 'required',
            'cuentaTypeDeposito' => 'required',
            'money' => 'numeric|min:1|max:1000',
            'concepto' => 'required|max:255',
            'password' => 'required|string|min:8|max:255'
        ],[
            'money.min' => 'La cantidad minima de venta es de 1$',
            'money.max' => 'La cantidad maxima de venta es de 1.000$'
        ]);

        $cuentaDolar = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'dolar')->where('cuentaType', $request->cuentaTypeLogin)->first();
        $cuentaFritos = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'nacional')->where('cuentaType', $request->cuentaTypeDeposito)->first();
        
        $monedas = Monedas::where('moneda', 'Fritos')->first();
        $monedasDolar = Monedas::where('moneda', 'Dolar')->first();

        if(Hash::check($request->password, Auth::user()->password)){
            if($request->fritosTotal < $monedas->reserva){
                if($request->money < $cuentaDolar->availableBalance){

                    $cuentaDolar->availableBalance = $cuentaDolar->availableBalance - $request->money;
                    $cuentaFritos->availableBalance = $cuentaFritos->availableBalance + $request->fritosTotal;
                    $monedas->reserva = $monedas->reserva - $request->fritosTotal;
                    $monedasDolar->reserva = $monedasDolar->reserva + $request->money;

                    $venta = $request->money * -1;

                    $historial = new HistorialDivisas();
                    $historial->cuentaDebitada = $cuentaDolar->accountNumber;
                    $historial->cuentaDepositada = $cuentaFritos->accountNumber;
                    $historial->venta = $venta;
                    $historial->monedaVenta = 'dolar';
                    $historial->compra = $request->fritosTotal;
                    $historial->monedaCompra = 'fritos';
                    $historial->concepto = $request->concepto;
                    $historial->user_id = Auth::user()->id;
                    
                    $historial->save();
                    $cuentaDolar->save();
                    $cuentaFritos->save();
                    $monedas->save();
                    $monedasDolar->save();

                    return redirect(route('monedas.index'))->with('message', 'Venta de Dolares Realizada!');

                }else{
                    return redirect(route('monedas.create'))->with('error', 'No tienes suficiente saldo en Fritos para esta operación.');
                }
            }else{
                return redirect(route('monedas.create'))->with('error', 'No hay reserva de divisa suficientes, intente más tarde.');
            }
        }else{
            return redirect(route('monedas.create'))->with('error', 'Contraseña Incorrecta');
        }

        return redirect(route('monedas.create'))->with('error', 'Ups, algo salio mal, intente de nuevo!');
    }
}
