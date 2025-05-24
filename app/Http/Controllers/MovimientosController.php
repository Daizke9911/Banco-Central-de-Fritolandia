<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovimientosRequest;
use App\Models\Cuentas;
use App\Models\Movimientos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class MovimientosController extends Controller
{
    public function index(){
        $movimientos = Movimientos::where('user_id',Auth::user()->id)
        ->orderBy('id', 'desc')
        ->paginate(3);

        foreach($movimientos as $movimiento){
            if($movimiento->moneda == "nacional"){
                $movimiento->moneda = "Fritos";
            }elseif($movimiento->moneda == "dolar"){
                $movimiento->moneda ="Dolar";
            }
        }
        
        return view('vistas.index_movimientos', compact('movimientos'));
    }

    public function create(){

        $cuentasLogin = Cuentas::where('user_id',Auth::user()->id)
        ->where('moneda', 'nacional')->get();
        return view('vistas.create_movimientos', compact('cuentasLogin'));
    }

    public function store(MovimientosRequest $request){
        if($request->cuentaTypeLogin == 1){
            $userLogin = User::where('id', Auth::user()->id)->first();
            $cuentaLogin = Cuentas::where('user_id', Auth::user()->id)
            ->where('moneda', 'nacional')
            ->where('cuentaType',$request->cuentaTypeLogin)->first();
        }elseif($request->cuentaTypeLogin == 2){
            $userLogin = User::where('id', Auth::user()->id)->first();
            $cuentaLogin = Cuentas::where('user_id', Auth::user()->id)
            ->where('moneda', 'nacional')
            ->where('cuentaType',$request->cuentaTypeLogin)->first();
        }else{
            //notify()->error('Error','Elija la cuenta a restar');
            return redirect(route('tranferencia'))->with('error','Elija la cuenta a restar');
        }

        $userDestino = User::where('cedula',$request->cedula)->first();
        $cuentaDestino = Cuentas::where('user_id',$userDestino->id)
        ->where('moneda', 'nacional')
        ->where('cuentaType',$request->cuentaType);
        
        if(isset($cuentaDestino)){
            if($request->cedula != $userLogin->cedula){ //validar que no es la misma cuenta del usuario login
                if(Hash::check($request->password, $userLogin->password)){  //validar la contraseña del usuario login
                    if($request->cuentaType == 1){ //condicional que realiza la operacion 
                        $cuentaDestino=$cuentaDestino->first();
                        $request->validate([
                            'cuentaType' => [
                            'required',
                            Rule::exists('cuentas', 'cuentaType')
                                ->where('user_id', $userDestino->id)
                                ->where('cuentaType', 1),
                            ],
                        ]); //validar si la cuenta destino existe
                        
                        if($request->money < $cuentaLogin->availableBalance){
                            $reference = random_int(1,999999999);
                            $numeroLimpio = preg_replace('/[^0-9]/', '', $request->money);
                            $moneyNegativo=$numeroLimpio * -1;
                            $IVA = $request->money * 0.02;
                            $cuentaLogin->availableBalance = $cuentaLogin->availableBalance - $request->money;
                            $cuentaLogin->availableBalance = $cuentaLogin->availableBalance - $IVA;
                            $cuentaDestino->availableBalance = $cuentaDestino->availableBalance + $request->money;
                            $date = now()->format('Y-m-d H:i:s');


                            $movimientos= new Movimientos();
                            $movimientos2 = new Movimientos();

                            $movimientos->user_id = $userDestino->id;
                            $movimientos->reference = $reference;
                            $movimientos->concept = $request->concepto;
                            $movimientos->movedMoney = $numeroLimpio;
                            $movimientos->saldo = $cuentaDestino->availableBalance;
                            $movimientos->cuentaType = $cuentaDestino->cuentaType;
                            $movimientos->moneda = "nacional";
                            $movimientos->cuenta_transferida = null;
                            $movimientos->user_id_transferido = null;
                            $movimientos->cuenta_recibida = $cuentaLogin->accountNumber;
                            $movimientos->user_id_recibido = $cuentaLogin->user_id;
                            $movimientos->created_at = $date;

                            $movimientos2->user_id = $userLogin->id;
                            $movimientos2->reference = $reference;
                            $movimientos2->concept = $request->concepto;
                            $movimientos2->movedMoney = $moneyNegativo;
                            $movimientos2->saldo = $cuentaLogin->availableBalance;
                            $movimientos2->cuentaType = $cuentaLogin->cuentaType;
                            $movimientos2->moneda = "nacional";
                            $movimientos2->cuenta_transferida = $cuentaDestino->accountNumber;
                            $movimientos2->user_id_transferido = $cuentaDestino->user_id;
                            $movimientos2->cuenta_recibida = null;
                            $movimientos2->user_id_recibido = null;
                            $movimientos2->created_at = $date;

                            $movimientos->save();
                            $movimientos2->save();
                            $cuentaDestino->save();
                            $cuentaLogin->save();

                            //notify()->success('','Transferencia Realizada!');
                            return redirect(route('movimientos.index'))->with('message', 'Transferencia Realizada!');
                        }else{ 
                            //notify()->error('Error','Saldo Insuficiente');
                            return redirect(route('tranferencia'))->with('error','Saldo insuficiente');
                        }
                    }elseif($request->cuentaType == 2){
                        $cuentaDestino=$cuentaDestino->first();
                        $request->validate([
                            'cuentaType' => [
                            'required',
                            Rule::exists('cuentas', 'cuentaType')
                                ->where('user_id', $userDestino->id)
                                ->where('cuentaType', 2),
                            ],
                        ]); //validar si la cuenta destino existe
                        if($request->money < $cuentaLogin->availableBalance){
                            $reference = random_int(1,999999999);
                            $numeroLimpio = preg_replace('/[^0-9]/', '', $request->money);
                            $moneyNegativo=$numeroLimpio * -1;
                            $IVA = $request->money * 0.02;
                            $cuentaLogin->availableBalance = $cuentaLogin->availableBalance - $request->money;
                            $cuentaLogin->availableBalance = $cuentaLogin->availableBalance - $IVA;
                            $cuentaDestino->availableBalance = $cuentaDestino->availableBalance + $request->money;
                            $date = now()->format('Y-m-d H:i:s');

                            $movimientos= new Movimientos();
                            $movimientos2 = new Movimientos();

                            $movimientos->user_id = $userDestino->id;
                            $movimientos->reference = $reference;
                            $movimientos->concept = $request->concepto;
                            $movimientos->movedMoney = $numeroLimpio;
                            $movimientos->saldo = $cuentaDestino->availableBalance;
                            $movimientos->cuentaType = $cuentaDestino->cuentaType;
                            $movimientos->moneda = "nacional";
                            $movimientos->cuenta_transferida = null;
                            $movimientos->user_id_transferido = null;
                            $movimientos->cuenta_recibida = $cuentaLogin->accountNumber;
                            $movimientos->user_id_recibido = $cuentaLogin->user_id;
                            $movimientos->created_at = $date;

                            $movimientos2->user_id = $userLogin->id;
                            $movimientos2->reference = $reference;
                            $movimientos2->concept = $request->concepto;
                            $movimientos2->movedMoney = $moneyNegativo;
                            $movimientos2->saldo = $cuentaLogin->availableBalance;
                            $movimientos2->cuentaType = $cuentaLogin->cuentaType;
                            $movimientos2->moneda = "nacional";
                            $movimientos2->cuenta_transferida = $cuentaDestino->accountNumber;
                            $movimientos2->user_id_transferido = $cuentaDestino->user_id;
                            $movimientos2->cuenta_recibida = null;
                            $movimientos2->user_id_recibido = null;
                            $movimientos2->created_at = $date;

                            $movimientos->save();
                            $movimientos2->save();
                            $cuentaDestino->save();
                            $cuentaLogin->save();

                            //notify()->success('','Transferencia Realizada!');
                            return redirect(route('movimientos.index'))->with('message', 'Transferencia Realizada!');
                        }else{
                        // notify()->error('Error','Saldo Insuficiente');
                            return redirect(route('tranferencia'))->with('error','Saldo insuficiente');
                        }
                    }else{
                    // notify()->error('verifique los datos','La Cuenta No Exise');
                        return redirect(route('tranferencia'))->with('error','Verifique los datos, la cuenta destinaria no existe');
                    }
                }else{
                // notify()->error('Error','Contraseña Incorrecta');
                    return redirect(route('tranferencia'))->with('error','Contraseña incorrecta');
                }
            }else{
                //notify()->error('Error','No Puedes Transferir a Tus Propias Cuentas');
                return redirect(route('tranferencia'))->with('error','No se puede transferir a cuentas propias');
            }
        }else{
            return redirect(route('tranferencia'))->with('error','La cuenta en Fritos no existe');
        }
    }

    public function createDolar(){
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

        $cuentasLogin = Cuentas::where('user_id', Auth::user()->id)
        ->where('moneda', 'dolar')->get();

        return view('vistas.create_movimientos_dolar', compact('cuentasLogin', 'i'));

    }

    public function storeDolar(MovimientosRequest $request){
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
        
        if($request->cuentaTypeLogin == 1){
            $userLogin = User::where('id', Auth::user()->id)->first();
            $cuentaLogin = Cuentas::where('user_id', Auth::user()->id)
            ->where('moneda', 'dolar')
            ->where('cuentaType',$request->cuentaTypeLogin)->first();
        }elseif($request->cuentaTypeLogin == 2){
            $userLogin = User::where('id', Auth::user()->id)->first();
            $cuentaLogin = Cuentas::where('user_id', Auth::user()->id)
            ->where('moneda', 'dolar')
            ->where('cuentaType',$request->cuentaTypeLogin)->first();
        }else{
            //notify()->error('Error','Elija la cuenta a restar');
            return redirect(route('tranferencia'))->with('error','Elija la cuenta a restar');
        }
        $userDestino = User::where('cedula',$request->cedula)->first();
        $cuentaDestino = Cuentas::where('user_id',$userDestino->id)
        ->where('moneda', 'dolar')
        ->where('cuentaType',$request->cuentaType);
        
        if(isset($cuentaDestino)){
            if($request->cedula != $userLogin->cedula){ //validar que no es la misma cuenta del usuario login
                if(Hash::check($request->password, $userLogin->password)){  //validar la contraseña del usuario login
                    if($request->cuentaType == 1){ //condicional que realiza la operacion 
                        $cuentaDestino=$cuentaDestino->first();
                        $request->validate([
                            'cuentaType' => [
                            'required',
                            Rule::exists('cuentas', 'cuentaType')
                                ->where('user_id', $userDestino->id)
                                ->where('cuentaType', 1),
                            ],
                        ]); //validar si la cuenta destino existe
                        
                        if($request->money < $cuentaLogin->availableBalance){
                            $reference = random_int(1,999999999);
                            $numeroLimpio = preg_replace('/[^0-9]/', '', $request->money);
                            $moneyNegativo=$numeroLimpio * -1;
                            $IVA = $request->money * 0.02;
                            $cuentaLogin->availableBalance = $cuentaLogin->availableBalance - $request->money;
                            $cuentaLogin->availableBalance = $cuentaLogin->availableBalance - $IVA;
                            $cuentaDestino->availableBalance = $cuentaDestino->availableBalance + $request->money;
                            $date = now()->format('Y-m-d H:i:s');


                            $movimientos= new Movimientos();
                            $movimientos2 = new Movimientos();

                            $movimientos->user_id = $userDestino->id;
                            $movimientos->reference = $reference;
                            $movimientos->concept = $request->concepto;
                            $movimientos->movedMoney = $numeroLimpio;
                            $movimientos->saldo = $cuentaDestino->availableBalance;
                            $movimientos->cuentaType = $cuentaDestino->cuentaType;
                            $movimientos->moneda = "dolar";
                            $movimientos->cuenta_transferida = null;
                            $movimientos->user_id_transferido = null;
                            $movimientos->cuenta_recibida = $cuentaLogin->accountNumber;
                            $movimientos->user_id_recibido = $cuentaLogin->user_id;
                            $movimientos->created_at = $date;

                            $movimientos2->user_id = $userLogin->id;
                            $movimientos2->reference = $reference;
                            $movimientos2->concept = $request->concepto;
                            $movimientos2->movedMoney = $moneyNegativo;
                            $movimientos2->saldo = $cuentaLogin->availableBalance;
                            $movimientos2->cuentaType = $cuentaLogin->cuentaType;
                            $movimientos2->moneda = "dolar";
                            $movimientos2->cuenta_transferida = $cuentaDestino->accountNumber;
                            $movimientos2->user_id_transferido = $cuentaDestino->user_id;
                            $movimientos2->cuenta_recibida = null;
                            $movimientos2->user_id_recibido = null;
                            $movimientos2->created_at = $date;

                            $movimientos->save();
                            $movimientos2->save();
                            $cuentaDestino->save();
                            $cuentaLogin->save();

                            //notify()->success('','Transferencia Realizada!');
                            return redirect(route('movimientos.index'))->with('message', 'Transferencia Realizada!');
                        }else{ 
                            //notify()->error('Error','Saldo Insuficiente');
                            return redirect(route('tranferencia'))->with('error','Saldo insuficiente');
                        }
                    }elseif($request->cuentaType == 2){
                        $cuentaDestino=$cuentaDestino->first();
                        $request->validate([
                            'cuentaType' => [
                            'required',
                            Rule::exists('cuentas', 'cuentaType')
                                ->where('user_id', $userDestino->id)
                                ->where('cuentaType', 2),
                            ],
                        ]); //validar si la cuenta destino existe
                        if($request->money < $cuentaLogin->availableBalance){
                            $reference = random_int(1,999999999);
                            $numeroLimpio = preg_replace('/[^0-9]/', '', $request->money);
                            $moneyNegativo=$numeroLimpio * -1;
                            $IVA = $request->money * 0.02;
                            $cuentaLogin->availableBalance = $cuentaLogin->availableBalance - $request->money;
                            $cuentaLogin->availableBalance = $cuentaLogin->availableBalance - $IVA;
                            $cuentaDestino->availableBalance = $cuentaDestino->availableBalance + $request->money;
                            $date = now()->format('Y-m-d H:i:s');

                            $movimientos= new Movimientos();
                            $movimientos2 = new Movimientos();

                            $movimientos->user_id = $userDestino->id;
                            $movimientos->reference = $reference;
                            $movimientos->concept = $request->concepto;
                            $movimientos->movedMoney = $numeroLimpio;
                            $movimientos->saldo = $cuentaDestino->availableBalance;
                            $movimientos->cuentaType = $cuentaDestino->cuentaType;
                            $movimientos->moneda = "dolar";
                            $movimientos->cuenta_transferida = null;
                            $movimientos->user_id_transferido = null;
                            $movimientos->cuenta_recibida = $cuentaLogin->accountNumber;
                            $movimientos->user_id_recibido = $cuentaLogin->user_id;
                            $movimientos->created_at = $date;

                            $movimientos2->user_id = $userLogin->id;
                            $movimientos2->reference = $reference;
                            $movimientos2->concept = $request->concepto;
                            $movimientos2->movedMoney = $moneyNegativo;
                            $movimientos2->saldo = $cuentaLogin->availableBalance;
                            $movimientos2->cuentaType = $cuentaLogin->cuentaType;
                            $movimientos2->moneda = "dolar";
                            $movimientos2->cuenta_transferida = $cuentaDestino->accountNumber;
                            $movimientos2->user_id_transferido = $cuentaDestino->user_id;
                            $movimientos2->cuenta_recibida = null;
                            $movimientos2->user_id_recibido = null;
                            $movimientos2->created_at = $date;

                            $movimientos->save();
                            $movimientos2->save();
                            $cuentaDestino->save();
                            $cuentaLogin->save();

                            //notify()->success('','Transferencia Realizada!');
                            return redirect(route('movimientos.index'))->with('message', 'Transferencia Realizada!');
                        }else{
                        // notify()->error('Error','Saldo Insuficiente');
                            return redirect(route('tranferencia'))->with('error','Saldo insuficiente');
                        }
                    }else{
                    // notify()->error('verifique los datos','La Cuenta No Exise');
                        return redirect(route('tranferencia'))->with('error','Verifique los datos, la cuenta destinaria no existe');
                    }
                }else{
                // notify()->error('Error','Contraseña Incorrecta');
                    return redirect(route('tranferencia'))->with('error','Contraseña incorrecta');
                }
            }else{
                //notify()->error('Error','No Puedes Transferir a Tus Propias Cuentas');
                return redirect(route('tranferencia'))->with('error','No se puede transferir a cuentas propias');
            }
        }else{
            return redirect(route('tranferencia'))->with('error','La cuenta en Dolares no existe');
        }
    }
    public function show($movimiento){
        $movimientos = Movimientos::where('user_id', Auth::user()->id)->find($movimiento);

        if($movimientos->moneda == "nacional"){
            $movimientos->moneda = "Fritos";
        }elseif($movimientos->moneda == "dolar"){
            $movimientos->moneda ="Dolar";
        }

        return view('vistas.show_movimientos', compact('movimientos'));
    }

    public function pdf_movimiento($id){
        $movimientos = Movimientos::find($id);
        return Pdf::loadView('vistas.pdf_movimientos', compact('movimientos'))->download($movimientos->reference . '.pdf');
    }
}