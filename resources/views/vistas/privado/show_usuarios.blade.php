<?php 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario {{$infoUser->name}}</title>
    <link rel="stylesheet" href="{{asset('styles/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/dashboard.css">
    <link rel="stylesheet" href="{{asset('styles/transferir.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/transferir.css">
    <link rel="stylesheet" href="{{asset('styles/show_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/show_movimientos.css">
    <x-temas />
</head>    
<body>
    <div class="dashboard-container">
        
        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Información del Usuario</h1>
                <div class="user-info">
                    <a class="logout-btn" href="{{route('logout')}}"  onclick="localStorage.removeItem('activeSidebarRoute');">Cerrar Sesión</a>
                </div>
            </header>

            <div class="detalle-container">
                <h2>Detalles del Usuario</h2>
                <div class="info-group">
                    <label>Nombre Completo:</label>
                    <span id="name">{{$infoUser->name}}</span>
                </div>
                <div class="info-group">
                    <label>Cédula:</label>
                    <span id="cedula">{{$infoUser->cedula}}</span>
                </div>
                <div class="info-group">
                    <label>Número Teléfonico:</label>
                    <span id="phone">{{$infoUser->phone}}</span>
                </div>
                <div class="info-group">
                    <label>Nacimiento:</label>
                    <span id="nacimientos">{{\Carbon\Carbon::parse($infoUser->nacimiento)->format('d/m/Y')}}</span>
                </div>
                <div class="info-group">
                    <label>Correo:</label>
                    <span id="email">{{$infoUser->email}}</span>
                </div>
                @foreach ($cuentas as $cuenta)
                    @if ($cuenta->cuentaType == 1)
                        <div class="info-group">
                            <label>Cuenta Corriente:</label>
                            <span id="cuentaCorriente">{{$cuenta->accountNumber}}</span>
                        </div>
                        <div class="info-group monto">
                            <label>Saldo:</label>
                            <span id="fecha-hora-transferencia">{{$cuenta->availableBalance}}</span>
                        </div>
                    @else
                        <div class="info-group">
                            <label>Cuenta Ahorro:</label>
                            <span id="cuentaCorriente">{{$cuenta->accountNumber}}</span>
                        </div>
                        <div class="info-group monto">
                            <label>Saldo:</label>
                            <span id="fecha-hora-transferencia">{{$cuenta->availableBalance}}</span>
                        </div>
                    @endif
                @endforeach
                
                
                <div class="acciones">
                    <a class="volver-a" href="{{route('usuarios.index')}}">Volver</a>
                </div>
            </div>
        </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const volverButton = document.querySelector('.volver-button');
            if (volverButton) {
                volverButton.addEventListener('click', function() {
                    // Simplemente volver a la página anterior
                    window.history.back();
                });
            }
        });
    </script>
</body>
</html>