<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzon - {{$detalles->estado}}</title>

    <x-head />  <!--HEAD DEL SISTEMA-->
    
    <link rel="stylesheet" href="{{asset('styles/transferir.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/transferir.css">
    <link rel="stylesheet" href="{{asset('styles/show_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/show_movimientos.css">
    <x-temas />
</head>    
<body>
    <div class="dashboard-container">
        
        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Buzon - Más Detalles</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <div class="content-area">

                <div class="detalle-container">
                    <h2>Detalles de 
                        @if ($detalles->ea == 1)
                            Entrada
                        @else
                            Salida
                        @endif
                    </h2>
                    <div class="info-group">
                        <label>Estado:</label>
                        <span id="name">{{$detalles->estado}}</span>
                    </div>
                    <div class="info-group">
                        <label>Descripción:</label>
                        <span id="cedula">{{$detalles->descripcion}}</span>
                    </div>
                    <div class="info-group">
                        @if ($detalles->ea == 1)
                            <label>Fecha recibida:</label>
                        @else
                            <label>Fecha enviada:</label>
                        @endif
                        <span id="cedula">{{$detalles->created_at}}</span>
                    </div>
                    @if ($detalles->oficina)
                        <div class="info-group">
                            <label>Oficina:</label>
                            <span id="phone">{{$detalles->oficina}}</span>
                        </div>
                    @endif

                    <div class="acciones">
                        <a class="volver-a" href="{{route('buzon.index')}}">Volver</a>
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