<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes</title>

    <x-head />  <!--HEAD DEL SISTEMA-->
    
    <link rel="stylesheet" href="{{asset('styles/index_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/index_movimientos.css">
    <link rel="stylesheet" href="{{asset('styles/index_solicitudes.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/index_solicitudes.css">
    
    <x-temas />
</head>
<body>

    <x-alertas /> <!--ALERTAS-->

    <div class="dashboard-container">
        
        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Bandeja de Solicitudes</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <div class="content-area">

                <div class="div-tablas">
                    <table id="miTablaDeDatos" class="tabla-movimientos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Solicitante</th>
                                <th>Fecha Solicitada</th>
                                <th>Solicitud</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-movimientos">
                            @foreach ($solicitudes as $solicitud)
                                <tr>
                                    <td>{{$solicitud->id}}</td>
                                    <td>{{$solicitud->user->name}}</td>
                                    <td>{{\Carbon\Carbon::parse($solicitud->updated_at)->format('d/m/Y H:i:s')}}</td>
                                    <td>{{$solicitud->tipo}}</td>
                                    <td>
                                        <div class="div-boton-solicitud">
                                            @if (Auth::user()->role == "admin")
                                                <form id="aceptarForm{{$solicitud->id}}" action="{{route('solicitudes.aceptar', $solicitud->id)}}" method="POST">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="button" class="boton-aceptar" onclick="confirmAceptar('{{$solicitud->user->name}}', 'aceptarForm{{$solicitud->id}}')">Aceptar</button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{route('solicitudes.show', $solicitud->id)}}" method="POST">
                                                @csrf
                                                @method('GET')
                                                <button type="submit" class="boton-info">Más Información</button>
                                            </form>
                                        </div>
                                        @if (Auth::user()->role == "admin")
                                            <div class="div-boton-solicitud">
                                                <form id="bloquearForm{{$solicitud->id}}" action="{{route('solicitudes.bloquear', $solicitud->id)}}" method="POST">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="button" class="boton-bloquear" onclick="confirmBloquear('{{$solicitud->user->name}}', 'bloquearForm{{$solicitud->id}}')">Bloquear</button>
                                                </form>
                                                <form id="rechazarForm{{$solicitud->id}}" action="{{route('solicitudes.rechazar', $solicitud->id)}}" method="POST">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="button" class="boton-delete" onclick="confirmRechazar('{{$solicitud->user->name}}', 'rechazarForm{{$solicitud->id}}')">Rechazar</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-pagination :users="$solicitudes"/>
                </div>


                <div class="div-tablas">
                    <h2 class="h2-bloqueo">Usuarios Bloqueados</h2>
                    <table id="miTablaDeDatos" class="tabla-movimientos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Usuario</th>
                                <th>Fecha Bloqueado</th>
                                <th>Razon</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-movimientos">
                            @foreach ($bloqueados as $bloqueado)
                                <tr>
                                    <td>{{$bloqueado->id}}</td>
                                    <td>{{$bloqueado->user->name}}</td>
                                    <td>{{\Carbon\Carbon::parse($bloqueado->updated_at)->format('d/m/Y H:i:s')}}</td>
                                    <td>{{$bloqueado->razon}}</td>
                                    <td>
                                        <div class="div-boton-solicitud">
                                            <form action="{{route('solicitudes.show', $bloqueado->id)}}" method="POST">
                                                @csrf
                                                @method('GET')
                                                <button type="submit" class="boton-info">Más Información</button>
                                            </form>
                                            @if (Auth::user()->role == "admin")
                                                <form id="desbloquearForm{{$bloqueado->id}}" action="{{route('solicitudes.desbloquear', $bloqueado->id)}}" method="POST">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="button" class="boton-desbloquear" onclick="confirmDesbloquear('{{$bloqueado->user->name}}', 'desbloquearForm{{$bloqueado->id}}')">Desbloquear</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-pagination :users="$bloqueados"/>
                </div>
            </div>
        </main>
    </div>
    <script>
        function confirmAceptar(userName, formId) {
            Swal.fire({
                title: `Aceptar la Solicitud de ${userName}`, // Título dinámico
                icon: "question",
                text: "Por favor, introduce tu contraseña para confirmar esta acción:",
                input: 'password', // Tipo de entrada: contraseña
                inputAttributes: {
                    autocapitalize: 'off' // Opcional: Desactivar autocapitalización
                },
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true, // Opcional: Mostrar spinner mientras se procesa
                preConfirm: (password) => {
                    // Validación básica: asegurarse de que se haya introducido algo
                    if (!password) {
                        Swal.showValidationMessage('Por favor, introduce tu contraseña');
                        return false; // No cierra el modal si está vacío
                    }
                    return password; // Retorna la contraseña para el siguiente paso
                },
                allowOutsideClick: () => !Swal.isLoading() // Opcional: No cerrar si el loader está activo
            }).then((result) => {
                // Se ejecuta después de que el usuario interactúa con el modal
                if (result.isConfirmed) {
                    const password = result.value; // La contraseña introducida está en result.value
                    const form = document.getElementById(formId); // Obtiene el formulario usando el ID pasado

                    if (form) {
                        // Crea un nuevo campo input oculto
                        const passwordInput = document.createElement('input');
                        passwordInput.type = 'hidden'; // Escondido
                        passwordInput.name = 'password'; // Nombre del campo que recibirá el controlador
                        passwordInput.value = password; // El valor es la contraseña introducida

                        // Añade el campo oculto al formulario
                        form.appendChild(passwordInput);

                        // Envía el formulario programáticamente
                        form.submit();

                        // Opcional: Mostrar un mensaje de éxito instantáneo (aunque la página probablemente redirija)
                        // Swal.fire('Confirmado!', 'La solicitud será procesada.', 'success');

                    } else {
                        console.error('Formulario no encontrado con ID:', formId);
                        Swal.fire('Error!', 'No se pudo encontrar el formulario para enviar.', 'error');
                    }

                } else if (result.isDismissed) {
                    // El usuario canceló el modal
                    Swal.fire('Solicitud Cancelada', 'La acción ha sido cancelada.', 'info');
                }
            });
        }

        function confirmBloquear(userName, formId) {
            Swal.fire({
                title: `Bloquear las Solicitudes a ${userName}`, // Título dinámico
                icon: "question",
                // --- Usamos 'html' para definir múltiples campos de entrada ---
                html: `
                    <label for="swal-input-reason" style="display: block; text-align: left; margin-bottom: 5px;">Razón del bloqueo:</label>
                    <input id="swal-input-reason" class="swal2-input" placeholder="Introduce la razón del bloqueo">

                    <label for="swal-input-password" style="display: block; text-align: left; margin-top: 15px; margin-bottom: 5px;">Contraseña:</label>
                    <input type="password" id="swal-input-password" class="swal2-input" placeholder="Introduce tu contraseña">
                `,
                // --- Es importante evitar que el foco vaya al botón inicialmente ---
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Confirmar Bloqueo',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true, // Opcional: Mostrar spinner
                // --- Adaptamos preConfirm para obtener AMBOS valores ---
                preConfirm: () => {
                    const reason = Swal.getPopup().querySelector('#swal-input-reason').value;
                    const password = Swal.getPopup().querySelector('#swal-input-password').value;

                    // Validación: asegurarse de que ambos campos tengan contenido
                    if (!reason || !password) {
                        Swal.showValidationMessage('Debes introducir tanto la razón como tu contraseña');
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
                        reasonInput.name = 'razon'; // Nombre del campo para el controlador
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
                    Swal.fire('Bloqueo Cancelado', 'La acción ha sido cancelada.', 'info');
                }
            });
        }

        function confirmRechazar(userName, formId) {
            Swal.fire({
                title: `Bloquear las Solicitudes a ${userName}`, // Título dinámico
                icon: "question",
                // --- Usamos 'html' para definir múltiples campos de entrada ---
                html: `
                    <label for="swal-input-reason" style="display: block; text-align: left; margin-bottom: 5px;">Razón del bloqueo:</label>
                    <input id="swal-input-reason" class="swal2-input" placeholder="Introduce la razón del bloqueo">

                    <label for="swal-input-password" style="display: block; text-align: left; margin-top: 15px; margin-bottom: 5px;">Contraseña:</label>
                    <input type="password" id="swal-input-password" class="swal2-input" placeholder="Introduce tu contraseña">
                `,
                // --- Es importante evitar que el foco vaya al botón inicialmente ---
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Confirmar Bloqueo',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true, // Opcional: Mostrar spinner
                // --- Adaptamos preConfirm para obtener AMBOS valores ---
                preConfirm: () => {
                    const reason = Swal.getPopup().querySelector('#swal-input-reason').value;
                    const password = Swal.getPopup().querySelector('#swal-input-password').value;

                    // Validación: asegurarse de que ambos campos tengan contenido
                    if (!reason || !password) {
                        Swal.showValidationMessage('Debes introducir tanto la razón como tu contraseña');
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
                        reasonInput.name = 'razon'; // Nombre del campo para el controlador
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
                    Swal.fire('Bloqueo Cancelado', 'La acción ha sido cancelada.', 'info');
                }
            });
        }

        function confirmDesbloquear(userName, formId) {
            Swal.fire({
                title: `Desbloquear a ${userName}`, // Título dinámico
                icon: "question",
                text: "Por favor, introduce tu contraseña para confirmar esta acción:",
                input: 'password', // Tipo de entrada: contraseña
                inputAttributes: {
                    autocapitalize: 'off' // Opcional: Desactivar autocapitalización
                },
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true, // Opcional: Mostrar spinner mientras se procesa
                preConfirm: (password) => {
                    // Validación básica: asegurarse de que se haya introducido algo
                    if (!password) {
                        Swal.showValidationMessage('Por favor, introduce tu contraseña');
                        return false; // No cierra el modal si está vacío
                    }
                    return password; // Retorna la contraseña para el siguiente paso
                },
                allowOutsideClick: () => !Swal.isLoading() // Opcional: No cerrar si el loader está activo
            }).then((result) => {
                // Se ejecuta después de que el usuario interactúa con el modal
                if (result.isConfirmed) {
                    const password = result.value; // La contraseña introducida está en result.value
                    const form = document.getElementById(formId); // Obtiene el formulario usando el ID pasado

                    if (form) {
                        // Crea un nuevo campo input oculto
                        const passwordInput = document.createElement('input');
                        passwordInput.type = 'hidden'; // Escondido
                        passwordInput.name = 'password'; // Nombre del campo que recibirá el controlador
                        passwordInput.value = password; // El valor es la contraseña introducida

                        // Añade el campo oculto al formulario
                        form.appendChild(passwordInput);

                        // Envía el formulario programáticamente
                        form.submit();

                        // Opcional: Mostrar un mensaje de éxito instantáneo (aunque la página probablemente redirija)
                        // Swal.fire('Confirmado!', 'La solicitud será procesada.', 'success');

                    } else {
                        console.error('Formulario no encontrado con ID:', formId);
                        Swal.fire('Error!', 'No se pudo encontrar el formulario para enviar.', 'error');
                    }

                } else if (result.isDismissed) {
                    // El usuario canceló el modal
                    Swal.fire('Desbloqueo Cancelada', 'La acción ha sido cancelada.', 'info');
                }
            });
        }
    </script>
</body>
</html>