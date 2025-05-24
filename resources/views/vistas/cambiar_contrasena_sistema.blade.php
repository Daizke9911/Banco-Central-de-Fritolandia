<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Cambiar Contraseña</title>

    <x-head />  <!--HEAD DEL SISTEMA-->

    <link rel="stylesheet" href="{{asset('styles/show_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/show_movimientosDos.css">
    <link rel="stylesheet" href="{{asset('styles/index_sistema.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/index_sistema.css">
    
    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        

        <x-sidebar />  <!--SIDEBAR-->
        
        <main class="main-content">
            <header>
                <h1>Configuraciones del Sistema</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>
            <div class="content-area">

                <x-botones_sistema />   <!--BOTONES-->

                <div class="detalle-container" style="margin: 50px auto;">
                    <x-alertas_bootstrap />
                    <div class="card-body">

                        <form method="POST" action="{{ route('validar_cambio_contrasena_sistema') }}">
                            @csrf

                            <h2>Cambiar Contraseña</h2>
                            <h3>Preguntas de Seguridad</h3>
                                <div class="mb-3">
                                    <label for="respuesta_1" class="form-label">{{ $user->pregunta_1}}:</label>
                                    <input id="respuesta_1" type="text" class="form-control @error('respuesta_1') is-invalid @enderror" name="respuesta_1" placeholder="Respuesta a la pregunta 1" required>
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="respuesta_2" class="form-label">{{ $user->pregunta_2}}:</label>
                                    <input id="respuesta_2" type="text" class="form-control @error('respuesta_2') is-invalid @enderror" name="respuesta_2" placeholder="Respuesta a la pregunta 2" required>
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="respuesta_3" class="form-label">{{ $user->pregunta_3 }}:</label>
                                    <input id="respuesta_3" type="text" class="form-control @error('respuesta_3') is-invalid @enderror" name="respuesta_3" placeholder="Respuesta a la pregunta 3" required>
                                    
                                </div>

                                <hr style="margin: 30px 0">

                                <h3>Nueva Contraseña</h3>
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nueva contraseña">
                                    
                                </div>
    
                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">{{ __('Confirmar Nueva Contraseña') }}</label>
                                    <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Repita la contraseña">
                                </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">{{ __('Cambiar Contraseña') }}</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>

            
        </main>
    </div>
</body>
</html>