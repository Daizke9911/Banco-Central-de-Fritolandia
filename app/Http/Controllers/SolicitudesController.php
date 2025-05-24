<?php

namespace App\Http\Controllers;

use App\Models\Buzon;
use App\Models\Cuentas;
use App\Models\Solicitudes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SolicitudesController extends Controller
{
    use AuthorizesRequests;

    public function index(Solicitudes $solicitud){
        if (! Gate::allows('viewAny', $solicitud)) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        $solicitudes = Solicitudes::with('user')
        ->where('estado', 2)
        ->orderBy('id', 'desc')
        ->paginate(3);

        $bloqueados = Solicitudes::with('user')
        ->where('estado', 3)
        ->orderBy('id', 'desc')
        ->paginate(3);

        foreach($solicitudes as $solicitud){
            if($solicitud->tipo == "mnc"){
                $solicitud->tipo = "Solicitud para cuenta corriente de moneda nacional.";
            }elseif($solicitud->tipo == "mna"){
                $solicitud->tipo = "Solicitud para cuenta ahorro de moneda nacional.";
            }elseif($solicitud->tipo == "mdc"){
                $solicitud->tipo = "Solicitud para cuenta corriente de moneda extranjera: Dolar $.";
            }elseif($solicitud->tipo == "mda"){
                $solicitud->tipo = "Solicitud para cuenta ahorro de moneda extranjera: Dolar $.";
            }else{
                $solicitud->tipo = "Solicitud no reconocida";
            }
        }

        
        return view('vistas.solicitudes.index_solicitudes', compact('solicitudes', 'bloqueados'));
    }

    public function show($solicitud){

        $solicitudes = Solicitudes::find($solicitud);

        if (! Gate::allows('view', $solicitudes)) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        $solicitud = $solicitudes;

        $infoUser = User::find($solicitudes->user_id);
        
        $cuentas = Cuentas::where('user_id', $infoUser->id)->get();

        if($solicitud->tipo == "mnc"){
            $solicitud->tipo = "Solicitud para cuenta corriente de moneda nacional.";
        }elseif($solicitud->tipo == "mna"){
            $solicitud->tipo = "Solicitud para cuenta ahorro de moneda nacional.";
        }elseif($solicitud->tipo == "mdc"){
            $solicitud->tipo = "Solicitud para cuenta corriente de moneda extranjera: Dolar $.";
        }elseif($solicitud->tipo == "mda"){
            $solicitud->tipo = "Solicitud para cuenta ahorro de moneda extranjera: Dolar $.";
        }

        

        return view('vistas.solicitudes.show_solicitudes', compact('infoUser', 'cuentas','solicitud'));
    }
    public function edit(){


        $cuentas = Cuentas::where('user_id', Auth::user()->id)->get();
        
        $t = 0;

        $mnc = 0; $mna = 0; $mdc = 0; $mda = 0;

        foreach ($cuentas as $cuenta) {
            if ($cuenta->cuentaType == 1 && $cuenta->moneda == "nacional") {
                $mnc++;
            }elseif($cuenta->cuentaType == 2 && $cuenta->moneda == "nacional"){
                $mna++;
            }elseif($cuenta->cuentaType == 1 && $cuenta->moneda == "dolar"){
                $mdc++;
            }elseif($cuenta->cuentaType == 2 && $cuenta->moneda == "dolar"){
                $mda++;
            }
            $t++;
        }

        if(Auth::user()->role == "admin"){
            return view('vistas.solicitudes.create_solicitudes');
        }elseif($t === 4 || $t <= 0){
            abort(403, 'Alcanzo la maxima cantidad de cuentas posibles');
        }

        return view('vistas.solicitudes.create_solicitudes');
    }

    public function update(Request $request, $userId){

        $solicitud = Auth::user()->solicitud;

        if($solicitud->estado == 2){
            abort(403, 'Su cuenta esta siendo procesada por el banco, tenga paciencia');
        }elseif($solicitud->estado == 3){
            abort(403, 'Usted se encuentra bloqueado para más aperturas de cuentas');
        }

        if($request->tipo == "mnc"){

            $buzon = new Buzon();
            $buzon->estado = "Solicitud";
            $buzon->descripcion = "Solicitud de apertura de cuenta corriente en moneda nacional ( Fritos ).";
            $buzon->ea = 2;
            $buzon->oficina = NULL;
            $buzon->user_id = Auth::user()->id;
            $buzon->save();

            $solicitud->tipo = $request->tipo;
            $solicitud->estado = 2;
            $solicitud->save();
            return redirect(route('solicitudes.edit', Auth::user()->id))->with('message','Cuenta Solicitada!');
        }elseif($request->tipo == "mna"){

            $buzon = new Buzon();
            $buzon->estado = "Solicitud";
            $buzon->descripcion = "Solicitud de apertura de cuenta ahorro en moneda nacional ( Fritos ).";
            $buzon->ea = 2;
            $buzon->oficina = NULL;
            $buzon->user_id = Auth::user()->id;
            $buzon->save();

            $solicitud->tipo = $request->tipo;
            $solicitud->estado = 2;
            $solicitud->save();
            return redirect(route('solicitudes.edit', Auth::user()->id))->with('message','Cuenta Solicitada!');
        }elseif($request->tipo == "mdc"){

            $buzon = new Buzon();
            $buzon->estado = "Solicitud";
            $buzon->descripcion = "Solicitud de apertura de cuenta corriente en dolares ( $ ).";
            $buzon->ea = 2;
            $buzon->oficina = NULL;
            $buzon->user_id = Auth::user()->id;
            $buzon->save();

            $solicitud->tipo = $request->tipo;
            $solicitud->estado = 2;
            $solicitud->save();
            return redirect(route('solicitudes.edit', Auth::user()->id))->with('message','Cuenta Solicitada!');
        }elseif($request->tipo == "mda"){

            $buzon = new Buzon();
            $buzon->estado = "Solicitud";
            $buzon->descripcion = "Solicitud de apertura de cuenta ahorro en dolares ( $ ).";
            $buzon->ea = 2;
            $buzon->oficina = NULL;
            $buzon->user_id = Auth::user()->id;
            $buzon->save();

            $solicitud->tipo = $request->tipo;
            $solicitud->estado = 2;
            $solicitud->save();
            return redirect(route('solicitudes.edit', Auth::user()->id))->with('message','Cuenta Solicitada!');
        }else{
            return redirect(route('solicitudes.edit', Auth::user()->id))->with('error','Ups, Algo salio mal');
        }
    }

    public function aceptar(Request $request ,Solicitudes $solicitud){
        if (! Gate::allows('aceptar', $solicitud)) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->with(['error' => 'La contraseña introducida es incorrecta.'])->withInput();
        }

        $userCreate = User::find($solicitud->user_id);
        $cuentas = Cuentas::where('user_id', $userCreate->id)->get();

        if($solicitud->tipo == "mnc"){

            foreach($cuentas as $cuenta){
                if($cuenta->moneda == "nacional" && $cuenta->cuentaType == 1){
                    return back()->with('error','La cuenta ya existe! Se recomienda rechazar esta solicitud');
                }
            }

            $buzon = new Buzon();
            $buzon->estado = "Aceptado";
            $buzon->descripcion = "Ha sido aceptado la solicitud de apertura de cuenta corriente en moneda nacional ( Fritos ).";
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $userCreate->id;
            $buzon->save();

            $cuenta = new Cuentas();
            $i=1;
                do{
                    $number= 9911000000 + $i;
                    $verificarCuenta = Cuentas::where('accountNumber',$number)->first();
                    if(empty($verificarCuenta->accountNumber)){
                        $cuenta->accountNumber = $number;
                        $cuenta->cuentaType = 1;
                        $cuenta->moneda = "nacional";
                        $number = 111;
                    }else{
                        $i++;
                    }
                }while($number != 111);
            $userCreate->cuenta()->save($cuenta); //crear cuenta

            $solicitud->tipo = NULL;
            $solicitud->estado = 1;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Solicitud Aceptada!');
        }elseif($solicitud->tipo == "mna"){

            foreach($cuentas as $cuenta){
                if($cuenta->moneda == "nacional" && $cuenta->cuentaType == 2){
                    return back()->with('error','La cuenta ya existe! Se recomienda rechazar esta solicitud');
                }
            }

            $buzon = new Buzon();
            $buzon->estado = "Aceptado";
            $buzon->descripcion = "Ha sido aceptado la solicitud de apertura de cuenta ahorro en moneda nacional ( Fritos ).";
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $userCreate->id;
            $buzon->save();

            $cuenta = new Cuentas();
            $i=1;
                do{
                    $number= 9911000000 + $i;
                    $verificarCuenta = Cuentas::where('accountNumber',$number)->first();
                    if(empty($verificarCuenta->accountNumber)){
                        $cuenta->accountNumber = $number;
                        $cuenta->cuentaType = 2;
                        $cuenta->moneda = "nacional";
                        $number = 111;
                    }else{
                        $i++;
                    }
                }while($number != 111);
            $userCreate->cuenta()->save($cuenta); //crear cuenta

            $solicitud->tipo = NULL;
            $solicitud->estado = 1;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Solicitud Aceptada!');
        }elseif($solicitud->tipo == "mdc"){

            foreach($cuentas as $cuenta){
                if($cuenta->moneda == "dolar" && $cuenta->cuentaType == 1){
                    return back()->with('error','La cuenta ya existe! Se recomienda rechazar esta solicitud');
                }
            }

            $buzon = new Buzon();
            $buzon->estado = "Aceptado";
            $buzon->descripcion = "Ha sido aceptado la solicitud de apertura de cuenta corriente en dolares ( $ ).";
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $userCreate->id;
            $buzon->save();

            $cuenta = new Cuentas();
            $i=1;
                do{
                    $number= 9912000000 + $i;
                    $verificarCuenta = Cuentas::where('accountNumber',$number)->first();
                    if(empty($verificarCuenta->accountNumber)){
                        $cuenta->accountNumber = $number;
                        $cuenta->cuentaType = 1;
                        $cuenta->moneda = "dolar";
                        $number = 111;
                    }else{
                        $i++;
                    }
                }while($number != 111);
            $userCreate->cuenta()->save($cuenta); //crear cuenta

            $solicitud->tipo = NULL;
            $solicitud->estado = 1;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Solicitud Aceptada!');
        }elseif($solicitud->tipo == "mda"){

            foreach($cuentas as $cuenta){
                if($cuenta->moneda == "dolar" && $cuenta->cuentaType == 2){
                    return back()->with('error','La cuenta ya existe! Se recomienda rechazar esta solicitud');
                }
            }

            $buzon = new Buzon();
            $buzon->estado = "Aceptado";
            $buzon->descripcion = "Ha sido aceptado la solicitud de apertura de cuenta ahorro en dolares ( $ ).";
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $userCreate->id;
            $buzon->save();

            $cuenta = new Cuentas();
            $i=1;
                do{
                    $number= 9912000000 + $i;
                    $verificarCuenta = Cuentas::where('accountNumber',$number)->first();
                    if(empty($verificarCuenta->accountNumber)){
                        $cuenta->accountNumber = $number;
                        $cuenta->cuentaType = 2;
                        $cuenta->moneda = "dolar";
                        $number = 111;
                    }else{
                        $i++;
                    }
                }while($number != 111);
            $userCreate->cuenta()->save($cuenta); //crear cuenta

            $solicitud->tipo = NULL;
            $solicitud->estado = 1;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Solicitud Aceptada!');
        }else{
            return redirect(route('solicitudes.index'))->with('error','Ups, Algo salio mal con la solicitud.');
        }

    }

    public function bloquear(Request $request, Solicitudes $solicitud){
        if (! Gate::allows('bloquear', $solicitud)) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->with(['error' => 'La contraseña introducida es incorrecta.'])->withInput();
        }

        if($solicitud->tipo == "mnc"){

            $buzon = new Buzon();
            $buzon->estado = "Bloqueado";
            $buzon->descripcion = "Algo se nos hizo sospechozo en tu solicitud, ha sido infraccionado por un bloqueo, razon: " . $request->razon;
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $solicitud->user_id;
            $buzon->save();

            $solicitud->tipo = NULL;
            $solicitud->estado = 3;
            $solicitud->razon = $request->razon;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Usuario Bloqueado!');
        }elseif($solicitud->tipo == "mna"){

            $buzon = new Buzon();
            $buzon->estado = "Bloqueado";
            $buzon->descripcion = "Algo se nos hizo sospechozo en tu solicitud, ha sido infraccionado por un bloqueo, razon: " . $request->razon;
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $solicitud->user_id;
            $buzon->save();

            $solicitud->tipo = NULL;
            $solicitud->estado = 3;
            $solicitud->razon = $request->razon;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Usuario Bloqueado!');
        }elseif($solicitud->tipo == "mdc"){

            $buzon = new Buzon();
            $buzon->estado = "Bloqueado";
            $buzon->descripcion = "Algo se nos hizo sospechozo en tu solicitud, ha sido infraccionado por un bloqueo, razon: " . $request->razon;
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $solicitud->user_id;
            $buzon->save();

            $solicitud->tipo = NULL;
            $solicitud->estado = 3;
            $solicitud->razon = $request->razon;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Usuario Bloqueado!');
        }elseif($solicitud->tipo == "mda"){

            $buzon = new Buzon();
            $buzon->estado = "Bloqueado";
            $buzon->descripcion = "Algo se nos hizo sospechozo en tu solicitud, ha sido infraccionado por un bloqueo, razon: " . $request->razon;
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $solicitud->user_id;
            $buzon->save();

            $solicitud->tipo = NULL;
            $solicitud->estado = 3;
            $solicitud->razon = $request->razon;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Usuario Bloqueado!');
        }else{
            return redirect(route('solicitudes.index'))->with('error','Ups, Algo salio mal con el bloqueo.');
        }
    }

    public function rechazar(Request $request, Solicitudes $solicitud){
        if (! Gate::allows('rechazar', $solicitud)) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->with(['error' => 'La contraseña introducida es incorrecta.'])->withInput();
        }

        if($solicitud->tipo == "mnc"){

            $buzon = new Buzon();
            $buzon->estado = "Rechazada";
            $buzon->descripcion = "Lo sentimos, su solicitud ha sido rechazada. Razon: " . $request->razon;
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $solicitud->user_id;
            $buzon->save();

            $solicitud->tipo = NULL;
            $solicitud->estado = 1;
            $solicitud->razon = "Rechazada | " . $request->razon;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Solicitud Rechazada!');
        }elseif($solicitud->tipo == "mna"){

            $buzon = new Buzon();
            $buzon->estado = "Rechazada";
            $buzon->descripcion = "Lo sentimos, su solicitud ha sido rechazada. Razon: " . $request->razon;
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $solicitud->user_id;
            $buzon->save();

            $solicitud->tipo = NULL;
            $solicitud->estado = 1;
            $solicitud->razon = "Rechazada | " . $request->razon;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Solicitud Rechazada!');
        }elseif($solicitud->tipo == "mdc"){

            $buzon = new Buzon();
            $buzon->estado = "Rechazada";
            $buzon->descripcion = "Lo sentimos, su solicitud ha sido rechazada. Razon: " . $request->razon;
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $solicitud->user_id;
            $buzon->save();

            $solicitud->tipo = NULL;
            $solicitud->estado = 1;
            $solicitud->razon = "Rechazada | " . $request->razon;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Solicitud Rechazada!');
        }elseif($solicitud->tipo == "mda"){

            $buzon = new Buzon();
            $buzon->estado = "Rechazada";
            $buzon->descripcion = "Lo sentimos, su solicitud ha sido rechazada. Razon: " . $request->razon;
            $buzon->ea = 1;
            $buzon->oficina = "Oficina Yaracuy";
            $buzon->user_id = $solicitud->user_id;
            $buzon->save();

            $solicitud->tipo = NULL;
            $solicitud->estado = 1;
            $solicitud->razon = "Rechazada | " . $request->razon;
            $solicitud->save();
            return redirect(route('solicitudes.index'))->with('success','Solicitud Rechazada!');
        }else{
            return redirect(route('solicitudes.index'))->with('error','Ups, Algo salio mal con el rechazo.');
        }
    }
    
    public function desbloquear(Request $request, Solicitudes $solicitud){
        if (! Gate::allows('desbloquear', $solicitud)) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->with(['error' => 'La contraseña introducida es incorrecta.'])->withInput();
        }

        $buzon = new Buzon();
        $buzon->estado = "Desbloqueado";
        $buzon->descripcion = "Su bloqueo ha sido retirado.";
        $buzon->ea = 1;
        $buzon->oficina = "Oficina Yaracuy";
        $buzon->user_id = $solicitud->user_id;
        $buzon->save();

        $solicitud->tipo = NULL;
        $solicitud->estado = 1;
        $solicitud->razon = NULL;
        $solicitud->save();
        return redirect(route('solicitudes.index'))->with('success','Usuario Desbloqueado!');
    }
}
