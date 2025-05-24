<?php 
use App\Models\Cuentas;

$cuentas = Cuentas::where('user_id', Auth::user()->id)->get();
$t = 0;
$i = 0;
$d = 0;

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Solicitudes</title>

    <x-head />  <!--HEAD DEL SISTEMA-->
    
    <link rel="stylesheet" href="{{asset('styles/create_servicios.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/create_servicios.css">
    <link rel="stylesheet" href="{{asset('styles/index_sistema.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/index_sistema.css">
    
    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Solicitudes de Cuenta</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <div class="content-area">

                <x-botones_sistema />   <!--BOTONES-->

                <x-alertas/>
                
                <div class="pagar-servicio-container" id="pagarServicioContainer" data-cuentas="{{ json_encode(1) }}">
                    @if (Auth::user()->solicitud->estado != 3)  <!--CUENTA BLOQUEADA-->
                        @if ($t < 4 || Auth::user()->id == 1)       <!--MAXIMO DE CUENTAS-->
                            @if (Auth::user()->solicitud->estado == 1)       <!--PERMITIR UNA APERTURA-->
                                <h2>Solicitar Nueva Cuenta</h2>

                                <div class="seleccion-servicio">
                                    
                                    <select id="servicio-seleccionado">
                                        <option value="">-- Seleccionar --</option>
                                        @if (!$mnc)
                                            <option value="mnc">Cuenta Nacional - Corriente</option>
                                        @endif
                                        @if (!$mna)
                                            <option value="mna">Cuenta Nacional - Ahorro</option>
                                        @endif
                                        @if (!$mdc)
                                            <option value="mdc">Cuenta en Dolares - Corriente</option>
                                        @endif
                                        @if (!$mda)
                                            <option value="mda">Cuenta en Dolares - Ahorro</option>
                                        @endif
                                    </select>
                                </div>

                                <div id="formulario-servicio" class="oculto">
                                    <!--CONTENIDO DE LOS FORMULARIOS-->
                                </div>
                            @endif
                            @if (Auth::user()->solicitud->estado == 2)
                                <h3>Su solicitud esta siendo procesada</h3>
                                <p>Espera la más pronta respuesta</p>
                            @endif
                                
                        @else
                            <h3>No existen más cuentas que aperturar</h3>
                        @endif
                    @else
                        <h3>Estimado cliente, el banco decidio bloquearle el servicio de solicitar cuenta</h3>
                        <p>Contactenos para más detalles del bloqueo</p>
                    @endif
                    
                    
                    
                </div>
            </div>
        </main>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const servicioSeleccionado = document.getElementById('servicio-seleccionado');
        const formularioServicio = document.getElementById('formulario-servicio');
        const pagarServicioContainer = document.getElementById('pagarServicioContainer');
        const cuentasLogin = JSON.parse(pagarServicioContainer.dataset.cuentas);

        servicioSeleccionado.addEventListener('change', function() {
            const servicio = this.value;
            formularioServicio.innerHTML = '';
            formularioServicio.classList.add('oculto');

            if (servicio === 'mnc') {
                formularioServicio.classList.remove('oculto');
                formularioServicio.innerHTML = `
                    <form method="POST" action="{{route('solicitudes.update', Auth::user()->id)}}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="mnc" name="tipo">

                        <h3>Solicitar Cuenta en Fritos: Corriente</h3>

                        <div class="form-group">
                            <button type="submit">Solicitar</button>
                        </div>
                    </form>
                `;
            }
            if (servicio === 'mna') {
                formularioServicio.classList.remove('oculto');
                formularioServicio.innerHTML = `
                    <form method="POST" action="{{route('solicitudes.update', Auth::user()->id)}}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="mna" name="tipo">

                        <h3>Solicitar Cuenta en Fritos: Ahorro</h3>

                        <div class="form-group">
                            <button type="submit">Solicitar</button>
                        </div>
                    </form>
                `;
            }
            if (servicio === 'mdc') {
                formularioServicio.classList.remove('oculto');
                formularioServicio.innerHTML = `
                    <form method="POST" action="{{route('solicitudes.update', Auth::user()->id)}}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="mdc" name="tipo">

                        <h3>Solicitar Cuenta en Dolares: Corriente</h3>

                        <div class="form-group">
                            <button type="submit">Solicitar</button>
                        </div>
                    </form>
                `;
            }
            if (servicio === 'mda') {
                formularioServicio.classList.remove('oculto');
                formularioServicio.innerHTML = `
                    <form method="POST" action="{{route('solicitudes.update', Auth::user()->id)}}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="mda" name="tipo">

                        <h3>Solicitar Cuenta en Dolares: Ahorro</h3>

                        <div class="form-group">
                            <button type="submit">Solicitar</button>
                        </div>
                    </form>
                `;
            }
        });
    });
</script>