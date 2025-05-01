<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persona</title>
    <link rel="stylesheet" href="{{asset('styles/login.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/styles_BCF@master/public/styles/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
    <x-alertas_bootstrap />

    <div class="login-container">
        <h2>Persona Natural</h2>
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
            <button type="submit" class="login-button">Ingresar</button>

            <div class="forgot-password">
                <a href="{{route('register')}}">¿Eres Nuevo? Registrate!</a>
            </div>
            <div class="forgot-password">
                <a href="{{route('vista_verificar_usuario')}}">¿Olvidaste la Contraseña?</a>
            </div>
        </form>
    </div>
</body>
</html>