<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="{{asset('styles/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/dashboard.css">
    <link rel="stylesheet" href="{{asset('styles/index_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/index_movimientos.css">
    <link rel="stylesheet" href="{{asset('styles/botones_index_usuarios.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/botones_index_usuarios.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <x-temas />
</head>
<body>
    <div class="dashboard-container">
        
        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Usuarios del Banco</h1>
                <div class="user-info">
                    <a class="logout-btn" href="{{route('logout')}}">Cerrar Sesión</a>
                </div>
            </header>
            
            <table id="tabla-movimientos">
                <thead>
                    <tr>
                        <th>MAXIMA AUTORIDAD</th>
                        <th></th>
                        <th></th>
                        @if (Auth::user()->role == "admin")
                            <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody id="tbody-movimientos">
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{$admin->name}}</td>
                            <td>{{$admin->email}}</td>
                            <td>{{$admin->role}}</td>
                            @if (Auth::user()->role == "admin")
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th>Moderadores</th>
                        <th></th>
                        <th></th>
                        @if (Auth::user()->role == "admin")
                            <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody id="tbody-movimientos">
                    @foreach($mods as $mod)
                        <tr>
                            <td>{{$mod->name}}</td>
                            <td>{{$mod->email}}</td>
                            <td>{{$mod->role}}</td>
                            @if (Auth::user()->role == "admin")
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-button">Opciones</button>
                                    <div class="dropdown-content">
                                    <a href="{{route('usuarios.show', $mod->id)}}">Más información</a>
                                    <a href="{{route('usuarios.edit', $mod->id)}}">Modificar</a>
                                    <a class="a-no">
                                        <form action="{{route('usuarios.destroy', $mod->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="boton-eliminar">Eliminar</button>
                                        </form>    
                                    </a>
                                    </div>
                                </div>
                            </td>
                            @endif
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <table id="miTablaDeDatos" class="tabla-movimientos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Nombre de Usuario</th>
                        <th>Contacto</th>
                        <th>
                            <a href="{{route('pdf')}}" class="pdf-generar">PDF</a>
                            @if (Auth::user()->role == "admin")
                                <button onclick="exportAllUsersFromData()" class="excel-generar">EXCEL</button>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody-movimientos">
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->phone}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-button">Opciones</button>
                                    <div class="dropdown-content">
                                    <a href="{{route('usuarios.show', $user->id)}}">Más información</a>
                                    <a href="{{route('usuarios.edit', $user->id)}}">Modificar</a>
                                    @if (Auth::user()->role == "admin")
                                        <a class="a-no">
                                            <form action="{{route('usuarios.destroy', $user->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="boton-eliminar">Eliminar</button>
                                            </form>    
                                        </a>
                                    @endif
                                    
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <x-pagination :users="$users"/>
        </main>
    </div>
<script>
        const usersData = @json($usersData); // Pasar los datos de PHP a JavaScript

        function exportAllUsersFromData(filename = 'usuarios_BCF.xlsx') {
            if (!usersData || usersData.length === 0) {
                console.error('No hay datos de usuarios para exportar.');
                return;
            }

            // Crear un nuevo libro de trabajo
            const wb = XLSX.utils.book_new();
            const ws_name = "Usuarios";

            // Convertir el array de objetos a una hoja de cálculo
            const ws = XLSX.utils.json_to_sheet(usersData);

            // Añadir la hoja al libro
            XLSX.utils.book_append_sheet(wb, ws, ws_name);

            // Descargar el archivo
            XLSX.writeFile(wb, filename);
        }
    </script>
</body>
</html>
