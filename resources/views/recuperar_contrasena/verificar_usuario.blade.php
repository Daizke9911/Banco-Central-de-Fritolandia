<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Recuperar Contraseña') }} - Paso 1</title>
    <link rel="stylesheet" href="{{asset('styles/register.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/styles_BCF@master/public/styles/register.css">
</head>
<body>

    <x-alertas_bootstrap />
    <div class="container">
        
        
        
                        <div class="card-header"><h3>{{ __('Recuperar Contraseña') }} - Paso 1</h3></div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('verificar_usuario') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="username" class="form-label">{{ __('Nombre de Usuario') }}</label>
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                                    
                                </div>

                                <div class="mb-3">
                                    <label for="cedula" class="form-label">{{ __('Cédula') }}</label>
                                    <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" value="{{ old('cedula') }}" required>
                                    
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">{{ __('Verificar') }}</button>
                                </div>
                            </form>
                        </div>
        
            <div class="login-link">
                <a href="{{route('login')}}">Regresar</a>
            </div>
        </form>
    </div>
</body>
</html>