<?php
$n = 0;
$d = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Información Personal</title>
    
    <x-head />  <!--HEAD DEL SISTEMA-->
    
    <link rel="stylesheet" href="{{asset('styles/show_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/show_movimientosDos.css">
    <link rel="stylesheet" href="{{asset('styles/index_sistema.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/index_sistema.css">

    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        <x-sidebar />  <!--SIDEBAR-->
        
        <main class="main-content">
            <header>
                <h1>Configuraciones del Sistema</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <div class="content-area">

                <x-botones_sistema />   <!--BOTONES-->

                <div class="detalle-container">
                    <h2>Información Personal</h2>
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
                        @if ($cuenta->moneda == "nacional")
                            @if ($n == 0)
                                <hr>
                                <h3>Cuentas en Moneda Nacional</h3>
                                <?php $n++; ?>
                            @endif
                        
                            @if ($cuenta->cuentaType == 1)
                                <div class="info-group">
                                    <label>Cuenta Corriente:</label>
                                    <span id="cuentaCorriente">{{$cuenta->accountNumber}}</span>
                                </div>
                                <div class="info-group monto">
                                    <label>Saldo:</label>
                                    <span id="fecha-hora-transferencia">{{$cuenta->availableBalance}} Fs.</span>
                                </div>
                            @else
                                <div class="info-group">
                                    <label>Cuenta Ahorro:</label>
                                    <span id="cuentaCorriente">{{$cuenta->accountNumber}}</span>
                                </div>
                                <div class="info-group monto">
                                    <label>Saldo:</label>
                                    <span id="fecha-hora-transferencia">{{$cuenta->availableBalance}} Fs.</span>
                                </div>
                            @endif
                        @else
                            @if ($d == 0)
                                <hr>
                                <h3>Cuentas en Dolares</h3>
                                <?php $d++; ?>
                            @endif
                            
                            @if ($cuenta->cuentaType == 1)
                                <div class="info-group">
                                    <label>Cuenta Corriente:</label>
                                    <span id="cuentaCorriente">{{$cuenta->accountNumber}}</span>
                                </div>
                                <div class="info-group monto">
                                    <label>Saldo:</label>
                                    <span id="fecha-hora-transferencia">{{$cuenta->availableBalance}} $.</span>
                                </div>
                            @else
                                <div class="info-group">
                                    <label>Cuenta Ahorro:</label>
                                    <span id="cuentaCorriente">{{$cuenta->accountNumber}}</span>
                                </div>
                                <div class="info-group monto">
                                    <label>Saldo:</label>
                                    <span id="fecha-hora-transferencia">{{$cuenta->availableBalance}} $.</span>
                                </div>
                            @endif
                        @endif
                        
                    @endforeach
                    
                </div>
            </div>
            

            
        </main>
    </div>
    </body>
</html>