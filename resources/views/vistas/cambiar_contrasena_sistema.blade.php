<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Cambiar Contraseña</title>
    <link rel="stylesheet" href="{{asset('styles/show_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/show_movimientos.css">
    <link rel="stylesheet" href="{{asset('styles/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/dashboard.css">
    <link rel="stylesheet" href="{{asset('styles/index_sistema.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/index_sistema.css">
    <script>
        window.sidebar = "{{ Auth::user()->tema->sidebar ?? null }}";
        window.buttonSidebar = "{{ Auth::user()->tema->button_sidebar ?? null }}";
        window.textColorSidebar = "{{ Auth::user()->tema->text_color_sidebar ?? null }}";
        window.backgraund = "{{ Auth::user()->tema->backgraund ?? null }}";
    </script>
    <script src="{{asset('js/theme.js')}}"></script>
</head>
<body>
    <div class="dashboard-container">

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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('validar_cambio_contrasena_sistema') }}">
                            @csrf

                            <h2>Cambiar Contraseña</h2>
                            <h3>Preguntas de Seguridad</h3>
                                <div class="mb-3">
                                    <label for="respuesta_1" class="form-label">{{ $user->pregunta_1}}:</label>
                                    <input id="respuesta_1" type="text" class="form-control @error('answer_{{ $user->id }}') is-invalid @enderror" name="respuesta_1" placeholder="Respuesta a la pregunta 1" required>
                                    @error('respuesta_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="respuesta_2" class="form-label">{{ $user->pregunta_2}}:</label>
                                    <input id="respuesta_2" type="text" class="form-control @error('answer_{{ $user->id }}') is-invalid @enderror" name="respuesta_2" placeholder="Respuesta a la pregunta 2" required>
                                    @error('respuesta_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="respuesta_3" class="form-label">{{ $user->pregunta_3 }}:</label>
                                    <input id="respuesta_3" type="text" class="form-control @error('answer_{{ $user->id }}') is-invalid @enderror" name="respuesta_3" placeholder="Respuesta a la pregunta 3" required>
                                    @error('respuesta_3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <hr style="margin: 30px 0">

                                <h3>Nueva Contraseña</h3>
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nueva contraseña">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">{{ __('Confirmar Nueva Contraseña') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Repita la contraseña">
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