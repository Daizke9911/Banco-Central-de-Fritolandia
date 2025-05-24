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

    if($movimientos->moneda == "nacional"){
        $movimientos->moneda = "Fritos";
    }elseif($movimientos->moneda == "dolar"){
        $movimientos->moneda =="Dolar";
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Transferencia</title>

    <style>
        .detalle-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            width: 400px;
            margin: auto;
            border: 1px solid #ccc; /* Opcional: Puedes tener un borde sólido base */
            box-shadow: 0 0 50px 20px rgba(0, 0, 0, 0.7);
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .info-group {
            margin-bottom: 15px;
            display: flex;
            gap: 15px;
            align-items: baseline;
        }

        .info-group label {
            color: #555;
            font-weight: bold;
            width: 150px;
            text-align: left;
        }

        .info-group span {
            color: #333;
            flex-grow: 1;
        }

        .info-group.monto span {
            font-size: 1.2em;
            font-weight: bold;
            color: #28a745; /* Color verde para indicar éxito */
        }

        .acciones {
            margin-top: 30px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .acciones button , a{
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .descargar-pdf-button {
            background-color: #17a2b8;
            color: white;
        }

        .descargar-pdf-button:hover {
            background-color: #138496;
        }

        .volver-button , .volver-a{
            background-color: #6c757d;
            color: white;
        }

        .volver-button:hover , .volver-a{
            background-color: #5a6268;
        }
        .h1{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="h1">
            <h1>Capture</h1>
            <h4>Banco Central de Fritolandia C.A 2025</h4>
        </div>
    
            <div class="detalle-container">
                <h2>Detalles de la Transferencia</h2>
                <div class="info-group">
                    <label>Referencia:</label>
                    <span id="reference">{{$movimientos->reference}}</span>
                </div>
                <div class="info-group">
                    <label>Concepto:</label>
                    <span id="concepto">{{$movimientos->concept}}</span>
                </div>
                <div class="info-group">
                    <label>Moneda Utilizada:</label>
                    <span id="concepto">{{$movimientos->moneda}}</span>
                </div>
                <div class="info-group">
                    <label>Monto de la Operación:</label>
                    <span id="montoOperacion">{{$movimientos->movedMoney}} Bs.</span>
                </div>
                <div class="info-group">
                    <label>Cuenta Origen:</label>
                    <span id="cuentaAfectada">{{$cuenta}}</span>
                </div>
                <div class="info-group">
                    <label>Cuenta Destino:</label>
                    <span id="cuentaInvolucrada">{{$tacho}}</span>
                </div>
                <div class="info-group">
                    <label>Fecha y Hora:</label>
                    <span id="fecha-hora-transferencia">{{\Carbon\Carbon::parse($movimientos->created_at)->format('d/m/Y')}}</span>
                </div>
            </div>

</body>
</html>