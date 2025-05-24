<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Historial</title>

    <x-head />  <!--HEAD DEL SISTEMA-->
    
    <link rel="stylesheet" href="{{asset('styles/transferir.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/transferir.css">
    <link rel="stylesheet" href="{{asset('styles/show_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/show_movimientosDos.css">
    <x-temas />
</head>    
<body>
    <div class="dashboard-container">
        
        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Detalles de la Compra de {{$historial->monedaCompra}}</h1>
                <div class="user-info">
                    
                    <x-logout />    <!--LOGOUT-->
                    
                </div>
            </header>

            <div class="content-area">

                <div class="detalle-container">
                    <div class="info-group">
                        <label>ID:</label>
                        <span id="name">{{$historial->id}}</span>
                    </div>
                    <div class="info-group">
                        <label>Concepto:</label>
                        <span id="cedula">{{$historial->concepto}}</span>
                    </div>
                    <hr>
                    <div class="info-group">
                        <label>Moneda Comprada:</label>
                        <span id="cedula">{{$historial->monedaCompra}}</span>
                        <div style="height: 10px; border-left: 1px solid black;"></div>
                        <label>Cantidad:</label>
                        @if ($historial->monedaCompra == "Fritos")
                            <span id="cedula" style="color: green; font-weight: bold;">{{$historial->compra}} Fs.</span>
                        @else
                            <span id="cedula" style="color: green; font-weight: bold;">{{$historial->compra}} $.</span>
                        @endif
                        
                    </div>
                    <div class="info-group">
                        <label>Cuenta Depositada:</label>
                        <span id="cedula">{{$historial->cuentaDepositada}}</span>
                    </div>
                    <hr>
                    <div class="info-group">
                        <label>Moneda Vendida:</label>
                        <span id="cedula">{{$historial->monedaVenta}}</span>
                        <div style="height: 10px; border-left: 1px solid black;"></div>
                        <label>Cantidad:</label>
                        @if ($historial->monedaVenta == "Fritos")
                            <span id="cedula" style="color: rgb(128, 0, 0); font-weight: bold;">{{$historial->venta}} Fs.</span>
                        @else
                            <span id="cedula" style="color: rgb(128, 0, 0); font-weight: bold;">{{$historial->venta}} $.</span>
                        @endif
                    </div>
                    <div class="info-group">
                        <label>Cuenta Depositada:</label>
                        <span id="cedula">{{$historial->cuentaDebitada}}</span>
                    </div>

                    <div class="acciones">
                        <a class="volver-a" href="{{route('monedas.index')}}">Volver</a>
                    </div>
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