<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\BuzonController;
use App\Http\Controllers\MonedasController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\SolicitudesController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

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

//RECUPERAR CONTRASEÑA DESDE EL LOGIN
Route::get('/recuperar/contrasena', [ForgotPasswordController::class, 'vista_verificar_usuario'])->name('vista_verificar_usuario');
Route::post('/validar/usuario', [ForgotPasswordController::class, 'verificar_usuario'])->name('verificar_usuario');
Route::get('/recuperar/contrasena/preguntas', [ForgotPasswordController::class, 'vista_preguntas_seguridad'])->name('vista_preguntas_seguridad')->middleware('password.recover');
Route::post('/validar/preguntas', [ForgotPasswordController::class, 'verificar_preguntas_seguridad'])->name('verificar_preguntas_seguridad')->middleware('password.recover');
Route::get('/recuperar/contrasena/cambiar', [ForgotPasswordController::class, 'vista_cambiar_contrasena'])->name('vista_cambiar_contrasena')->middleware('password.recover');
Route::post('/validar/contrasena/cambio', [ForgotPasswordController::class, 'verificar_cambiar_contrasena'])->name('verificar_cambiar_contrasena')->middleware('password.recover');

//SIDEBAR//////////////
Route::get('/transferencia', [MovimientosController::class, 'create'])
->middleware(['auth', 'verified'])->name('tranferencia');
Route::get('/transferencia/dolar', [MovimientosController::class, 'createDolar'])
->middleware(['auth', 'verified'])->name('tranferencia.dolar');
Route::post('/transferencia/dolar/procesando', [MovimientosController::class, 'storeDolar'])
->middleware(['auth', 'verified'])->name('tranferencia.storeDolar');
Route::resource('movimientos', MovimientosController::class)
->only(['index','store','show'])->middleware(['auth', 'verified'])->names('movimientos');
Route::resource('servicio', ServiciosController::class)
->only(['create','store'])->middleware(['auth', 'verified'])->names('servicios');
Route::resource('usuarios', UsersController::class)
->only(['index','show', 'edit', 'update', 'destroy'])->middleware(['auth', 'verified'])->names('usuarios');

//SISTEMA
Route::get('/sistema', [SistemaController::class, 'usuario'])->middleware(['auth', 'verified'])->name('sistema.index');
Route::get('/cambiar/contrasena', [SistemaController::class, 'cambio_contrasena'])->middleware(['auth', 'verified'])->name('cambio_contrasena_sistema');
Route::post('/cambiar/contrasena/validar', [SistemaController::class, 'validar'])->middleware(['auth', 'verified'])->name('validar_cambio_contrasena_sistema');
Route::get('/aspectos', [SistemaController::class, 'aspecto'])->middleware(['auth', 'verified'])->name('aspecto');
Route::post('/update-aspecto', [SistemaController::class, 'update_aspecto'])->middleware(['auth', 'verified'])->name('update_aspecto');

//PDF USUARIOS
Route::get('/pdf', [UsersController::class, 'pdf'])->middleware(['auth', 'verified'])->name('pdf');
//PDF MOBIMIENTOS
Route::get('/movimientos/pdf/{id}', [MovimientosController::class, 'pdf_movimiento'])->middleware(['auth', 'verified'])->name('pdf_movimientos');

//SOLICITUDES
Route::resource('solicitudes', SolicitudesController::class)
->only(['index','show', 'edit', 'update'])->middleware(['auth', 'verified'])->names('solicitudes');
Route::get('/solicitudes/aceptar/{solicitud}', [SolicitudesController::class, 'aceptar'])->middleware(['auth', 'verified'])->name('solicitudes.aceptar');
Route::get('/solicitudes/bloquear/{solicitud}', [SolicitudesController::class, 'bloquear'])->middleware(['auth', 'verified'])->name('solicitudes.bloquear');
Route::get('/solicitudes/rechazar/{solicitud}', [SolicitudesController::class, 'rechazar'])->middleware(['auth', 'verified'])->name('solicitudes.rechazar');
Route::get('/solicitudes/desbloquear/{solicitud}', [SolicitudesController::class, 'desbloquear'])->middleware(['auth', 'verified'])->name('solicitudes.desbloquear');

//BUZON
Route::get('/buzon', [BuzonController::class, 'index'])->middleware(['auth', 'verified'])->name('buzon.index');
Route::get('/buzon/{info}', [BuzonController::class, 'show'])->middleware(['auth', 'verified'])->name('buzon.show');

//DIVISA
Route::resource('divisas', MonedasController::class)
->only(['index', 'create', 'show', 'store'])->middleware(['auth', 'verified'])->names('monedas');
Route::get('/divisa/venta', [MonedasController::class, 'venta'])->middleware(['auth', 'verified'])->name('createVenta');
Route::post('/divisa/venta/confirm', [MonedasController::class, 'ventaConfirm'])->middleware(['auth', 'verified'])->name('storeVenta');

//RESERVA
Route::resource('reservas', ReservasController::class)
->only(['index', 'update'])->middleware(['auth', 'verified'])->names('reservas');