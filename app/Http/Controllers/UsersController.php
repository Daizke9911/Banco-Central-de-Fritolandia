<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Models\Cuentas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UsersController extends Controller
{
    use AuthorizesRequests;
    
    public function index(){

        if (! Gate::allows('viewAny', auth()->user())) {
            abort(403, 'No tienes autorización para esta pagina, compre oro');
        }
        
        $admins = User::where('role', 'admin')->get();
        $mods = User::where('role', 'mod')->get();

        $users=User::where('id', '!=', Auth::user()->id)->where('role', '!=', "admin")->where('role', '!=', "mod")->paginate(3);
        
        //EXCEL

        $usersExcel=User::where('id', '!=', Auth::user()->id)->where('role', '!=', "admin")->where('role', '!=', "mod")->get();
        
        $usersData = [];

        foreach ($usersExcel as $user) {
            $userData = [
                'ID' => $user->id,
                'Nombre' => $user->name,
                'Usuario' => $user->username,
                'Cedula' => $user->cedula,
                'Telefono' => $user->phone,
                'Nacimiento' => $user->nacimiento,
                'Correo' => $user->email,
                'Rol' => $user->role,
            ];

            $cuentas = Cuentas::where('user_id', $user->id)->get(); // Obtener las cuentas como arrays

            foreach ($cuentas as $index => $cuenta) {
                $userData['Cuenta ' . ($index + 1)] = $cuenta['accountNumber'] ?? '';
                $userData['Saldo ' . ($index + 1)] = $cuenta['availableBalance'] ?? '';
                $userData['Tipo Cuenta ' . ($index + 1)] = ($cuenta['cuentaType'] == 1) ? 'Corriente' : (($cuenta['cuentaType'] == 2) ? 'Ahorro' : '');
            }

            $usersData[] = $userData;
        }

        return view('vistas.privado.index_usuarios', compact('users', 'admins', 'mods', 'usersData'), ['exportAll' => true]);
    }

    public function show($user){
        
        $userToEdit = User::findOrFail($user);
        $this->authorize('view', $userToEdit);

        $infoUser=User::find($user);
        $cuentas = Cuentas::where('user_id',$infoUser->id)->get();
        return view('vistas.privado.show_usuarios', compact('infoUser', 'cuentas'));
    }

    public function edit($user){

        $userToEdit = User::findOrFail($user);
        $this->authorize('update', $userToEdit);

        $infoUser=User::find($user);
        $cuentas = Cuentas::where('user_id',$infoUser->id)->get();
        return view('vistas.privado.edit_usuarios', compact('infoUser', 'cuentas'));
    }

    public function update(UsersRequest $request, $infoUser){
        $userToEdit = User::findOrFail($infoUser); // Buscar el usuario por ID
        $this->authorize('update', $userToEdit); 

        $user = User::find($infoUser);
        
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
                        'accountNumberCorriente' => 'required|numeric|min:9911000000|max:9911999999|unique:cuentas,accountNumber,'.$cuenta->id,
                        'availableBalanceCorriente' => 'required|numeric'
                    ],
                    [
                        'accountNumberCorriente.min' => 'El numero de cuenta debe ser 10 digitos y comenzar con 9911',
                        'accountNumberCorriente.max' => 'El numero de cuenta debe ser 10 digitos y comenzar con 9911'
                    ]);

                    $cuenta->accountNumber = $request->accountNumberCorriente;
                    $cuenta->availableBalance = $request->availableBalanceCorriente;
                    $cuenta->save();
                }else{
                    $request->validate([
                        'accountNumberAhorro' => 'required|numeric|min:9911000000|max:9911999999|unique:cuentas,accountNumber,'.$cuenta->id,
                        'availableBalanceAhorro' => 'required|numeric'
                    ],
                    [
                        'accountNumberAhorro.min' => 'El numero de cuenta debe ser 10 digitos y comenzar con 9911',
                        'accountNumberAhorro.max' => 'El numero de cuenta debe ser 10 digitos y comenzar con 9911'
                    ]);

                    $cuenta->accountNumber = $request->accountNumberAhorro;
                    $cuenta->availableBalance = $request->availableBalanceAhorro;
                    $cuenta->save();
                }
            }
            
            return redirect(route('usuarios.index'))->with('message', 'Editado con Exito!');
        }else{
            return redirect(route('usuarios.edit', $infoUser))->with('error', 'Contraseña Incorrecta, intente de nuevo');
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
