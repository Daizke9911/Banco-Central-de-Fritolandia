<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Recuperar Contraseña') }} - Paso 2</title>
    <link rel="icon" href="{{asset('files/logo_bcf.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('styles/register.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/styles_BCF@master/styles/registerDos.css">
</head>
<body>
    <div class="container">
        
        <x-alertas_bootstrap />
        
                        <div class="card-header"><h3>{{ __('Recuperar Contraseña') }} - Paso 2</h3></div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('verificar_preguntas_seguridad') }}">
                                @csrf

                                    <div class="mb-3">
                                        <label for="respuesta_1" class="form-label">{{ $user->pregunta_1}}:</label>
                                        <input id="respuesta_1" type="text" class="form-control @error('answer_{{ $user->id }}') is-invalid @enderror" name="respuesta_1" required>
                                        @error('respuesta_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="respuesta_2" class="form-label">{{ $user->pregunta_2}}:</label>
                                        <input id="respuesta_2" type="text" class="form-control @error('answer_{{ $user->id }}') is-invalid @enderror" name="respuesta_2" required>
                                        @error('respuesta_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="respuesta_3" class="form-label">{{ $user->pregunta_3 }}:</label>
                                        <input id="respuesta_3" type="text" class="form-control @error('answer_{{ $user->id }}') is-invalid @enderror" name="respuesta_3" required>
                                        @error('respuesta_3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">{{ __('Verificar Respuestas') }}</button>
                                </div>
                            </form>
                        </div>
                
         
    </div>
</body>
</html>