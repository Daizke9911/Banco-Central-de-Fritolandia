<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Aspectos del Sistema</title>
    <link rel="stylesheet" href="{{asset('styles/show_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/show_movimientos.css">
    <link rel="stylesheet" href="{{asset('styles/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/dashboard.css">
    <link rel="stylesheet" href="{{asset('styles/index_sistema.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/index_sistema.css">
    <style>
        .paleta-color {
            display: inline-block;
            width: 50px;
            border-radius: 10px;
            height: 50px;
            margin: 5px;
            cursor: pointer;
            display: inline-block; /* Para que el ancho y alto se ajusten al contenido */
            transition: transform 0.3s cubic-bezier(0.4, 2, 0.6, 1); /* Transición suave con curva personalizada */
        }
        
        .paleta-color:hover {
            transform: scale(1.1); /* Escala al 110% al pasar el ratón */
        }
    </style>
    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        <x-alertas />

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Configuraciones del Sistema</h1>
                <div class="user-info">
                    <a class="logout-btn" href="{{route('logout')}}">Cerrar Sesión</a>
                </div>
            </header>
            <div class="content-area">

                <x-botones_sistema />   <!--BOTONES-->

                <div class="detalle-container" style="margin: 50px auto">
                    <div class="card-body">

                        <h3>Eliga un color</h3>
                        <div id="paleta-de-colores">
                            <div class="paleta-color" style="background-color: #800000;" data-color="#800000"></div>
                            <div class="paleta-color" style="background-color: #158000;" data-color="#158000"></div>
                            <div class="paleta-color" style="background-color: #000080;" data-color="#000080"></div>
                            <div class="paleta-color" style="background-color: #808000;" data-color="#808000"></div>
                            <div class="paleta-color" style="background-color: #008080;" data-color="#008080"></div>
                            <div class="paleta-color" style="background-color: #800080;" data-color="#800080"></div>
                        </div>
                        <form id="formulario-color" action="{{ route('update_aspecto') }}" method="POST">
                            @csrf
                            <input type="hidden" name="sidebar" id="color_seleccionado">
                        </form>
                        
                    </div>
                    
                </div>
            </div>

            
        </main>

        <script>
            const paletaColores = document.getElementById('paleta-de-colores');
            const formularioColor = document.getElementById('formulario-color');
            const colorSeleccionadoInput = document.getElementById('color_seleccionado');
    
            paletaColores.addEventListener('click', function(event) {
                if (event.target.classList.contains('paleta-color')) {
                    const sidebar = event.target.dataset.color;
                    // document.body.style.backgroundColor = sidebar; // Vista previa (opcional)
                    colorSeleccionadoInput.value = sidebar;
                    formularioColor.submit(); // Envía el formulario automáticamente
                }
            });
        </script>
    </div>
    </body>
</html>