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
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Recuperar Contraseña') }} - Paso 3</h3></div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('verificar_cambiar_contrasena') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
            </div>
        </div>

         
    </div>
</body>
</html>