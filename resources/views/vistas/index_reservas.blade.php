<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas del Banco</title>
    
    <x-head />  <!--HEAD DEL SISTEMA-->
    
    <link rel="stylesheet" href="{{asset('styles/show_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/show_movimientosDos.css">

    
    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        <x-alertas />

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Reserva Bancaria</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <div class="content-area">

                <div class="detalle-container-reserva">
                    @foreach ($reservas as $reserva)
                        <div class="card-body" style="margin: auto; justify-content: center;">
                            <div class="div-monedas-reservas">
                                <h2>{{$reserva->moneda}}</h2>
                                <h3>{{$reserva->reserva}}
                                    @if ($reserva->moneda == "Fritos")
                                         Fs.
                                    @else
                                         $.
                                    @endif
                                </h3>
                                <form id="updateReserva{{$reserva->id}}" action="{{ route('reservas.update', $reserva->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="boton-reserva" onclick="confirmUpdate('{{$reserva->moneda}}', 'updateReserva{{$reserva->id}}')">Modificar {{$reserva->moneda}}</button>
                                </form>
                            </div>

                            
                            
                        </div>
                    @endforeach
                    
                </div>

            </div>

            
        </main>
    </div>
    <script>
        function confirmUpdate(userName, formId) {
            Swal.fire({
                title: `Seguro de Modificar la Reserva de ${userName}`, // Título dinámico
                icon: "question",
                // --- Usamos 'html' para definir múltiples campos de entrada ---
                html: `
                    <label for="swal-input-reason" style="display: block; text-align: left; margin-bottom: 5px;">Cantidad Nueva:</label>
                    <input id="swal-input-reason" class="swal2-input" placeholder="Introduce la nueva cantidad">

                    <label for="swal-input-password" style="display: block; text-align: left; margin-top: 15px; margin-bottom: 5px;">Contraseña:</label>
                    <input type="password" id="swal-input-password" class="swal2-input" placeholder="Introduce tu contraseña">
                `,
                // --- Es importante evitar que el foco vaya al botón inicialmente ---
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Confirmar la Modificaión',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true, // Opcional: Mostrar spinner
                // --- Adaptamos preConfirm para obtener AMBOS valores ---
                preConfirm: () => {
                    const reason = Swal.getPopup().querySelector('#swal-input-reason').value;
                    const password = Swal.getPopup().querySelector('#swal-input-password').value;

                    // Validación: asegurarse de que ambos campos tengan contenido
                    if (!reason || !password) {
                        Swal.showValidationMessage('Debes introducir tanto la cantidad como tu contraseña');
                        return false; // No cierra el modal si falta algo
                    }

                    // Puedes añadir validaciones adicionales aquí si lo necesitas

                    // Devuelve AMBOS valores (puedes usar un objeto o un array)
                    // Devolver un objeto con nombres descriptivos es más claro
                    return { reason: reason, password: password };
                },
                allowOutsideClick: () => !Swal.isLoading() // Opcional: No cerrar si el loader está activo
            }).then((result) => {
                // Se ejecuta después de que el usuario interactúa y preConfirm pasa
                if (result.isConfirmed) {
                    // --- result.value contendrá el objeto que devolvimos en preConfirm ---
                    const reason = result.value.reason;
                    const password = result.value.password;

                    const form = document.getElementById(formId); // Obtiene el formulario

                    if (form) {
                        // --- Crea un campo input oculto para la RAZÓN ---
                        const reasonInput = document.createElement('input');
                        reasonInput.type = 'hidden';
                        reasonInput.name = 'reserva'; // Nombre del campo para el controlador
                        reasonInput.value = reason;
                        form.appendChild(reasonInput); // Añade al formulario

                        // --- Crea un campo input oculto para la CONTRASEÑA ---
                        const passwordInput = document.createElement('input');
                        passwordInput.type = 'hidden';
                        passwordInput.name = 'password'; // Nombre del campo para el controlador
                        passwordInput.value = password;
                        form.appendChild(passwordInput); // Añade al formulario

                        // Envía el formulario programáticamente (ahora con ambos campos ocultos)
                        form.submit();

                    } else {
                        console.error('Formulario no encontrado con ID:', formId);
                        Swal.fire('Error!', 'No se pudo encontrar el formulario para enviar.', 'error');
                    }

                } else if (result.isDismissed) {
                    // El usuario canceló el modal
                    Swal.fire('Modificación Cancelada', 'La acción ha sido cancelada.', 'info');
                }
            });
        }
    </script>
</body>
</html>