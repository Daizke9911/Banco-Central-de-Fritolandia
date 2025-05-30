<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Recuperar Contraseña') }} - Paso 3</title>
    <link rel="icon" href="{{asset('files/logo_bcf.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('styles/register.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/register.css">
    <link rel="stylesheet" href="{{asset('styles/paginacion_bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/paginacion_bootstrap.css">
    
</head>
<body>
    <div class="container">

        <x-alertas_bootstrap />
        
                    <div class="card-header"><h3>{{ __('Recuperar Contraseña') }} - Paso 3</h3></div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('verificar_cambiar_contrasena') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                
                            </div>

                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">{{ __('Confirmar Nueva Contraseña') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">{{ __('Restablecer Contraseña') }}</button>
                            </div>
                        </form>
                    </div>

         
    </div>
</body>
</html>