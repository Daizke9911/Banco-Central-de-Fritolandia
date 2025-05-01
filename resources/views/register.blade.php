<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperturar Cuenta</title>
    <link rel="stylesheet" href="{{asset('styles/register.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/register.css">
</head>
<body>
    
    <x-alertas_bootstrap />

    <div class="container">
        <h1>Aperturar Cuenta Bancaria</h1>
        <form action="{{route('validar-registro')}}" method="POST">

            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nombre Completo:</label>
                    <input type="text" id="name" name="name" value="{{old('name')}}" class="@error('name}') is-invalid @enderror" required>
                </div>
                <div class="form-group">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" id="username" name="username" value="{{old('username')}}" class="@error('username') is-invalid @enderror" required>
                </div>
                <div class="form-group">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" value="{{old('email')}}" class="@error('email') is-invalid @enderror" required>
                </div>
                <div class="form-group">
                    <label for="cedula">Número de Cédula:</label>
                    <input type="tel" id="cedula" name="cedula" value="{{old('cedula')}}" class="@error('cedula') is-invalid @enderror" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Teléfono:</label>
                    <input type="tel" id="phone" name="phone" value="{{old('phone')}}" class="@error('phone') is-invalid @enderror" required>
                </div>
                <div class="form-group">
                    <label for="nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="nacimiento" name="nacimiento" value="{{old('nacimiento')}}" class="@error('nacimiento') is-invalid @enderror" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="cuentaType">Eliga un tipo de cuenta</label>
                    <select name="cuentaType" id="cuentaType"  class="@error('cuentaType') is-invalid @enderror">
                        <option value=""></option>
                        <option value="1">Corriente</option>
                        <option value="2">Ahorro</option>
                    </select>
                </div>
                <div class="form-group">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña:</label>
                    <input type="password" id="password_confirmation" class="@error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                </div>
            </div>

            <hr style="margin: 30px 0">

            <h3>Preguntas de seguridad</h3>
            <p>Escriba una pregunta y su respectiva respuesta</p>
            <div class="form-row">
                <div class="form-group">
                    <label for="pregunta1">Pregunta 1:</label>
                    <input type="text" id="pregunta1" name="pregunta_1" value="{{old('pregunta_1')}}" class="@error('pregunta_1') is-invalid @enderror" required>
                </div>
                <div class="form-group">
                    <label for="respuesta1">Respuesta a la pregunta 1:</label>
                    <input type="text" id="respuesta1" name="respuesta_1" value="{{old('respuesta_1')}}" class="@error('respuesta_1') is-invalid @enderror" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="pregunta2">Pregunta 2:</label>
                    <input type="text" id="pregunta2" name="pregunta_2" value="{{old('pregunta_2')}}" class="@error('pregunta_2') is-invalid @enderror" required>
                </div>
                <div class="form-group">
                    <label for="respuesta2">Respuesta a la pregunta 2:</label>
                    <input type="text" id="respuesta2" name="respuesta_2" value="{{old('respuesta_2')}}" class="@error('respuesta_2') is-invalid @enderror" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="pregunta3">Pregunta 3:</label>
                    <input type="text" id="pregunta3" name="pregunta_3" value="{{old('pregunta_3')}}" class="@error('pregunta_3') is-invalid @enderror" required>
                </div>
                <div class="form-group">
                    <label for="respuesta3">Respuesta a la pregunta 3:</label>
                    <input type="text" id="respuesta3" name="respuesta_3" value="{{old('respuesta_3')}}" class="@error('respuesta_3') is-invalid @enderror" required>
                </div>
            </div>

            <div class="form-group full-width">
                <button type="submit">Registrarse</button>
            </div>
            <div class="login-link">
                ¿Ya tienes una cuenta? <a href="{{route('login')}}">Inicia Sesión</a>
            </div>
        </form>
    </div>
</body>
</html>