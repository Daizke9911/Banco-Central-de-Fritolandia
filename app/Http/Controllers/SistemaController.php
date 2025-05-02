<?php

namespace App\Http\Controllers;

use App\Models\Cuentas;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SistemaController extends Controller
{
    public function usuario(){
        $infoUser = Auth::user();
        $cuentas = Cuentas::where('user_id',$infoUser->id)->get();

        return view('vistas.index_sistema', compact('infoUser', 'cuentas'));

    }

    public function cambio_contrasena(){
        $user = Auth::user();
        return view('vistas.cambiar_contrasena_sistema', compact('user'));
    }

    public function validar(Request $request){
        $user = User::find(Auth::user()->id);

        if(Hash::check($request->respuesta_1, $user->respuesta_1)){
            if(Hash::check($request->respuesta_2, $user->respuesta_2)){
                if(Hash::check($request->respuesta_3, $user->respuesta_3)){

                    $request->validate([
                        'password' => ['required', 'string', 'confirmed', 'max: 255', 'min:8']
                    ]);
                    $user->password = Hash::make($request->password);
                    $user->save();
                    
                    return back()->with('success', 'La contraseña cambio con exito!');
                }else{
                    
                    return back()->with(['error' => 'Las respuestas 3 de seguridad es incorrecta.'])->withInput();
                }
            }else{
                return back()->with(['error' => 'Las respuestas 2 de seguridad es incorrecta.'])->withInput();
            }
        }else{
            return back()->with(['error' => 'Las respuestas 1 de seguridad es incorrecta.'])->withInput();
        }
    }

    public function aspecto(){
        $user = Auth::user();
        return view('vistas.aspectos_sistema', compact('user'));
    }

    public function update_aspecto(Request $request){
        $request->validate([
            'sidebar' => 'nullable|string|max:7', // Valida que sea una cadena (ej: #RRGGBB)
        ]);
        
        if(Auth::user()->tema()->where('user_id', Auth::id())->exists()){
            if($request->sidebar == "#800000"){
                $tema = Auth::user()->tema;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#b62121";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');

            }elseif($request->sidebar == "#158000"){
                $tema = Auth::user()->tema;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#36a320";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }elseif($request->sidebar == "#000080"){
                $tema = Auth::user()->tema;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#2b2baa";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }elseif($request->sidebar == "#808000"){
                $tema = Auth::user()->tema;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#a8a820";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }elseif($request->sidebar == "#008080"){
                $tema = Auth::user()->tema;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#1ea5a5";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }elseif($request->sidebar == "#800080"){
                $tema = Auth::user()->tema;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#992899";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }
            
        }else{

            if($request->sidebar == "#800000"){
                $tema = new Tema();
            $tema->user_id = Auth::user()->id;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#b62121";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');

            }elseif($request->sidebar == "#158000"){
                $tema = new Tema();
            $tema->user_id = Auth::user()->id;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#36a320";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }elseif($request->sidebar == "#000080"){
                $tema = new Tema();
            $tema->user_id = Auth::user()->id;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#2b2baa";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }elseif($request->sidebar == "#808000"){
                $tema = new Tema();
            $tema->user_id = Auth::user()->id;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#a8a820";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }elseif($request->sidebar == "#008080"){
                $tema = new Tema();
            $tema->user_id = Auth::user()->id;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#1ea5a5";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }elseif($request->sidebar == "#800080"){
                $tema = new Tema();
            $tema->user_id = Auth::user()->id;
                $tema->sidebar = $request->sidebar;
                $tema->button_sidebar = "#992899";
                $tema->text_color_sidebar = "#fff";
                $tema->background = "";
                $tema->save();

                return back()->with('success', '¡Color de pestaña guardado!');
            }
        }
        

        
    }
}
