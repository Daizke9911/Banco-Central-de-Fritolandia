<?php
use App\Models\Cuentas;

$cuentas = Cuentas::where('user_id', Auth::user()->id)->get();
$i = 0;
$d = 0;

foreach ($cuentas as $cuenta) {
    if ($cuenta->moneda == "nacional") {
        $i++;
    }elseif($cuenta->moneda == "dolar"){
        $d++;
    }
}
?>
<div class="barra-superior">
    <a href="{{route('sistema.index')}}">Información Personal</a>
    <a href="{{route('cambio_contrasena_sistema')}}">Cambiar Contraseña</a>
    <a href="{{route('aspecto')}}">Cambiar Aspecto del Sistema</a>
    @if ($i < 2 || $d < 2 || Auth::user()->id == 1)
        <a href="{{route('solicitudes.edit', Auth::user()->id)}}">Solicitar Cuenta</a>
    @endif
    
</div>