<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="{{asset('styles/login.css')}}">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form id="login-form" method="POST" action="{{route('iniciar-sesion')}}">

            @csrf

            <div class="input-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Entrar</button>

            <div class="forgot-password">
                <a href="{{route('olvide')}}">¿Olvidaste tu contraseña?</a>
            </div>
            <div class="forgot-password">
                <a href="{{route('register')}}">¿Eres Nuevo? Registrate!</a>
            </div>
        </form>
    </div>
</body>
</html>