<?php

namespace App\Http\Controllers;

use App\Models\Cuentas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class UsersController extends Controller
{
    public function index(){

        if (! Gate::allows('viewAny', auth()->user())) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }
        
        $admins = User::where('role', 'admin')->get();
        $mods = User::where('role', 'mod')->get();

        $users=User::where('id', '!=', Auth::user()->id)->where('role', '!=', "admin")->where('role', '!=', "mod")->paginate(3);
        return view('vistas.privado.index_usuarios', compact('users', 'admins', 'mods'));
    }

    public function show($user){
        if (! Gate::allows('view', auth()->user())) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        $infoUser=User::find($user);
        $cuentas = Cuentas::where('user_id',$infoUser->id)->get();
        return view('vistas.privado.show_usuarios', compact('infoUser', 'cuentas'));
    }

    public function edit($user){
        if (! Gate::allows('update', auth()->user())) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        $infoUser=User::find($user);
        $cuentas = Cuentas::where('user_id',$infoUser->id)->get();
        return view('vistas.privado.edit_usuarios', compact('infoUser', 'cuentas'));
    }

    public function update(Request $request, $infoUser){
        if (! Gate::allows('update', auth()->user())) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }

        $user = User::find($infoUser);

        $request->validate([
            'name' => 'required|max:100',
            'username' => 'required|max:100',
            'cedula' => 'required|numeric|min:100000|max:99999999|unique:users,cedula,'.$user->id,
            'phone' => 'required|numeric|min:10000000000|max:99999999999|unique:users,phone,'.$user->id,
            'nacimiento' => 'required|date',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
        
        if(Hash::check($request->password, Auth::user()->password)){
            
            $user->name = $request->name;
            $user->username = $request->username;
            $user->cedula = $request->cedula;
            $user->nacimiento = $request->nacimiento;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();

            
            $cuentas = Cuentas::where('user_id', $infoUser)->get();
            foreach($cuentas as $cuenta){
                if($cuenta->cuentaType == 1){
                    $request->validate([
                        'accountNumberCorriente' => 'required|unique:cuentas,accountNumber,'.$cuenta->id,
                        'availableBalanceCorriente' => 'required|numeric'
                    ]);

                    $cuenta->accountNumber = $request->accountNumberCorriente;
                    $cuenta->availableBalance = $request->availableBalanceCorriente;
                    $cuenta->save();
                }else{
                    $request->validate([
                        'accountNumberAhorro' => 'required|unique:cuentas,accountNumber,'.$cuenta->id,
                        'availableBalanceAhorro' => 'required|numeric'
                    ]);

                    $cuenta->accountNumber = $request->accountNumberAhorro;
                    $cuenta->availableBalance = $request->availableBalanceAhorro;
                    $cuenta->save();
                }
            }
            
            return redirect(route('usuarios.index'));
        }else{
            return redirect(route('usuarios.edit', $infoUser));
        }
        
    }

    public function destroy($infoUser){
        if (! Gate::allows('delete', auth()->user())) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }
        
        $user = User::find($infoUser);
        $user->delete();

        return redirect(route('usuarios.index'));
    }

    public function pdf(){
        if (! Gate::allows('viewAny', auth()->user())) {
            abort(403, 'No tienes autorización para esta acción, compre oro');
        }

        $users = User::where('id', '!=', Auth::user()->id)->get();
        $pdf = Pdf::loadView('vistas.privado.pdf_usuarios', compact('users'));
        return $pdf->stream();
    }
}
