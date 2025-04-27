<?php 
    if($movimientos->cuentaType == 1){
        $cuenta = "Corriente";
    }else{
        $cuenta = "Ahorro";
    }

    if ($movimientos->cuenta_transferida) {
        $tacho = maskNumber($movimientos->cuenta_transferida, 4, 3);
    }else{
        $tacho = maskNumber($movimientos->cuenta_recibida, 4, 3);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Transferencia</title>
    <link rel="stylesheet" href="{{asset('styles/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('styles/transferir.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/transferir.css">
    <link rel="stylesheet" href="{{asset('styles/show_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/show_movimientos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        
        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Historial de Movimientos</h1>
                <div class="user-info">
                    <a class="logout-btn" href="{{route('logout')}}">Cerrar Sesión</a>
                </div>
            </header>

            <div class="detalle-container">
                <h2>Detalle de Transferencia</h2>
                <div class="info-group">
                    <label>Referencia:</label>
                    <span id="reference"></span>
                </div>
                <div class="info-group">
                    <label>Concepto:</label>
                    <span id="concepto"></span>
                </div>
                <div class="info-group">
                    <label>Monto de la Operación:</label>
                    <span id="montoOperacion"></span>
                </div>
                <div class="info-group monto">
                    <label>Saldo Total:</label>
                    <span id="saldoTotal"></span>
                </div>
                <div class="info-group">
                    <label>Tu Cuenta Afectada:</label>
                    <span id="cuentaAfectada"></span>
                </div>
                <div class="info-group">
                    <label>Cuenta Involucrada:</label>
                    <span id="cuentaInvolucrada"></span>
                </div>
                <div class="info-group">
                    <label>Fecha y Hora:</label>
                    <span id="fecha-hora-transferencia"></span>
                </div>
                <div class="acciones">
                    <button class="descargar-pdf-button">Descargar PDF</button>
                    <button class="volver-button" scr="{{route('movimientos.index')}}">Volver</button>
                </div>
            </div>
        </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);

            document.getElementById('reference').textContent = urlParams.get('reference') || '{{$movimientos->reference}}';
            document.getElementById('concepto').textContent = urlParams.get('concepto') || '{{$movimientos->concept}}';
            document.getElementById('montoOperacion').textContent = (parseFloat(urlParams.get('montoOperacion')) || {{$movimientos->movedMoney}}).toFixed(2) + ' Bs';
            document.getElementById('saldoTotal').textContent = urlParams.get('saldoTotal') || '{{$movimientos->saldo}}';
            document.getElementById('cuentaAfectada').textContent = urlParams.get('cuentaAfectada') || '{{$cuenta}}';
            document.getElementById('cuentaInvolucrada').textContent = urlParams.get('cuentaInvolucrada') || '{{$tacho}}';

            // Simulación de fecha y hora (en una aplicación real, esto vendría del servidor)
            const now = '{{$movimientos->created_at}}';
            const formattedDateTime = now.toLocaleString('es-VE'); // Formato local de Venezuela
            document.getElementById('fecha-hora-transferencia').textContent = formattedDateTime;

            // Funcionalidad simulada para los botones
            const descargarPdfButton = document.querySelector('.descargar-pdf-button');
            if (descargarPdfButton) {
                descargarPdfButton.addEventListener('click', function() {
                    alert('Simulando la descarga del PDF...');
                    // Aquí iría la lógica real para generar y descargar el PDF
                });
            }

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