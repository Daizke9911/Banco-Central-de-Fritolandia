<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//LOGIN, REGISTER Y LOGOUT
Route::view('/login', "login")->name('login');
Route::view('/register', "register")->name('register');
Route::view('/recuperar-contrasena', "olvide_contrasena")->name('olvide-contrasena');
Route::view('/dashboard', "dashboard")->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/validar-registro',[LoginController::class, 'register'])
->name('validar-registro');
Route::post('/iniciar-sesion',[LoginController::class, 'login'])
->name('iniciar-sesion');
Route::get('/logout',[LoginController::class, 'logout'])
->name('logout');

//RECUPERAR CONTRASEÑA
Route::get('/recuperar/contrasena', [ForgotPasswordController::class, 'vista_verificar_usuario'])->name('vista_verificar_usuario');
Route::post('/validar/usuario', [ForgotPasswordController::class, 'verificar_usuario'])->name('verificar_usuario');
Route::get('/recuperar/contrasena/preguntas', [ForgotPasswordController::class, 'vista_preguntas_seguridad'])->name('vista_preguntas_seguridad')->middleware('password.recover');
Route::post('/validar/preguntas', [ForgotPasswordController::class, 'verificar_preguntas_seguridad'])->name('verificar_preguntas_seguridad')->middleware('password.recover');
Route::get('/recuperar/contrasena/cambiar', [ForgotPasswordController::class, 'vista_cambiar_contrasena'])->name('vista_cambiar_contrasena')->middleware('password.recover');
Route::post('/validar/contrasena/cambio', [ForgotPasswordController::class, 'verificar_cambiar_contrasena'])->name('verificar_cambiar_contrasena')->middleware('password.recover');


Route::get('/transferencia', [MovimientosController::class, 'create'])
->middleware(['auth', 'verified'])->name('tranferencia');
Route::resource('movimientos', MovimientosController::class)
->only(['index','store','show'])->middleware(['auth', 'verified'])->names('movimientos');
Route::resource('servicio', ServiciosController::class)
->only(['create','store'])->middleware(['auth', 'verified'])->names('servicios');
Route::resource('usuarios', UsersController::class)
->only(['index','show', 'edit', 'update', 'destroy'])->middleware(['auth', 'verified'])->names('usuarios');

//SISTEMA
Route::view('/sistema', "vistas.index_sistema")->middleware(['auth', 'verified'])->name('sistema.index');