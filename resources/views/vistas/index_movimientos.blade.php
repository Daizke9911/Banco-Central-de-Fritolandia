<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
    
    <x-head />  <!--HEAD DEL SISTEMA-->

    <link rel="stylesheet" href="{{asset('styles/index_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/styles_BCF@master/styles/index_movimientosDos.css">
    
    <x-temas />
</head>
<body>
    @if (session('message'))
        <script>
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: "{{session('message')}}",
            showConfirmButton: false,
            timer: 1500
            });
        </script>
    @endif
    <div class="dashboard-container">
        
        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Historial de Movimientos</h1>
                <div class="user-info">
                    <a class="logout-btn" href="{{route('logout')}}" onclick="localStorage.removeItem('activeSidebarRoute');">Cerrar Sesión</a>
                </div>
            </header>

            <div class="content-area">

                <table id="tabla-movimientos">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Referencia</th>
                            <th>Monto (Bs)</th>
                            <th>Concepto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody-movimientos">

                    </tbody>
                </table>
                <x-pagination :users="$movimientos"/>
            </div>
        </main>
    </div>

    @foreach ($movimientos as $movimiento)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tbodyMovimientos = document.getElementById('tbody-movimientos');

                // Simulación de datos de movimientos (en una aplicación real, esto vendría del servidor)
                const movimientos = [
                    { id: {{$movimiento->id}}, fecha: '{{$movimiento->created_at}}', referencia: '{{$movimiento->reference}}', monto: {{$movimiento->movedMoney}}, concepto: '{{$movimiento->concept}}' },
                    // ... más movimientos
                ];

                movimientos.forEach(movimiento => {
                    const row = tbodyMovimientos.insertRow();

                    const fechaCell = row.insertCell();
                    fechaCell.textContent = new Date(movimiento.fecha).toLocaleString('es-VE');

                    const referenciaCell = row.insertCell();
                    referenciaCell.textContent = movimiento.referencia;

                    const montoCell = row.insertCell();
                    montoCell.textContent = (movimiento.monto).toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    montoCell.classList.add(movimiento.monto < 0 ? 'negativo' : 'positivo');

                    const conceptoCell = row.insertCell();
                    conceptoCell.textContent = movimiento.concepto;

                    const accionesCell = row.insertCell();
                    const detalleButton = document.createElement('button');
                    detalleButton.textContent = 'Más Detalles';
                    detalleButton.classList.add('ver-detalle-button');
                    detalleButton.addEventListener('click', function() {
                        // Redirigir a la página de detalles pasando el ID del movimiento
                        window.location.href = `{{route('movimientos.show', $movimiento->id)}}`;
                    });
                    accionesCell.appendChild(detalleButton);
                });
            });
        </script>
    @endforeach
   
</body>
</html>