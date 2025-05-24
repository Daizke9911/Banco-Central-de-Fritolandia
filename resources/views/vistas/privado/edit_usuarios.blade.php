<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar {{$infoUser->name}}</title>

    <x-head />  <!--HEAD DEL SISTEMA-->

    <link rel="stylesheet" href="{{asset('styles/edit_usuarios.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/edit_usuarios.css">
    
    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Editar al Usuario {{$infoUser->username}}</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <div class="content-area">

                <x-alertas_bootstrap />
                
                <div class="container">
                    <form action="{{route('usuarios.update', $infoUser->id)}}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Nombre Completo:</label>
                                <input type="text" id="name" name="name" value="{{old('name', $infoUser->name)}}" class="@error('name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Nombre de Usuario:</label>
                                <input type="text" id="username" name="username" value="{{old('username', $infoUser->username)}}" class="@error('username') is-invalid @enderror" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Correo Electrónico:</label>
                                <input type="email" id="email" name="email" value="{{old('email', $infoUser->email)}}" class="@error('email') is-invalid @enderror" required>
                            </div>
                            <div class="form-group">
                                <label for="cedula">Número de Cédula:</label>
                                <input type="tel" id="cedula" name="cedula" value="{{old('cedula', $infoUser->cedula)}}" class="@error('cedula') is-invalid @enderror" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Teléfono:</label>
                                <input type="tel" id="phone" name="phone" value="{{old('phone', $infoUser->phone)}}" class="@error('phone') is-invalid @enderror" required>
                            </div>
                            <div class="form-group">
                                <label for="nacimiento">Fecha de Nacimiento:</label>
                                <input type="date" id="nacimiento" name="nacimiento" value="{{old('nacimiento', $infoUser->nacimiento)}}" class="@error('nacimiento') is-invalid @enderror" required>
                            </div>
                        </div>
                        @if (Auth::user()->role == "admin")
                            
                        @foreach ($cuentas as $cuenta)
                                @if ($cuenta->cuentaType == 1)
                                <hr>
                                    <h3>Cuenta Corriente del Usuario</h3>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="accountNumberCorriente">Cuenta:</label>
                                            <input type="tel" id="accountNumberCorriente" name="accountNumberCorriente" value="{{old('accountNumberCorriente', $cuenta->accountNumber)}}" class="@error('accountNumberCorriente') is-invalid @enderror" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="availableBalanceCorriente">Saldo:</label>
                                            <input type="numeric" id="availableBalanceCorriente" name="availableBalanceCorriente" value="{{old('availableBalanceCorriente', $cuenta->availableBalance)}}" class="@error('availableBalanceCorriente') is-invalid @enderror" required>
                                        </div>
                                    </div>
                                @else
                                    <hr>
                                    <h3>Cuenta Ahorro del Usuario</h3>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="accountNumberAhorro">Cuenta:</label>
                                            <input type="tel" id="accountNumberAhorro" name="accountNumberAhorro" value="{{old('accountNumberAhorro', $cuenta->accountNumber)}}" class="@error('accountNumberCorriente') is-invalid @enderror" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="availableBalanceAhorro">Saldo:</label>
                                            <input type="numeric" id="availableBalanceAhorro" name="availableBalanceAhorro" value="{{old('availableBalanceAhorro', $cuenta->availableBalance)}}" class="@error('availableBalance') is-invalid @enderror" required>
                                        </div>
                                    </div>
                                @endif
                            @endforeach 
                            <hr>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="role">Asignar Rol</label>
                                    <select name="role" id="role" class="@error('role') is-invalid @enderror">
                                        <option value="{{$infoUser->role}}">Asigne un rol único al usuario</option>
                                        <option value="admin">Administrador</option>
                                        <option value="mod">Moderador</option>
                                        <option value="user">Usuario</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <p>Nota: si no se selecciona nada el usuario mantiene su rol actual</p>
                                </div>
                            </div>
                        @endif

                        <hr>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" required>
                            </div>
                            <div class="form-group">
                                <p>Debe ingresar la contraseña para realizar esta operación</p>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <button type="submit">Editar</button>
                        </div>
                        <div class="form-group full-width">
                            <a class="volver-a" style="text-decoration: none" href="{{route('usuarios.index')}}">Volver</a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </main>
</body>
</html>