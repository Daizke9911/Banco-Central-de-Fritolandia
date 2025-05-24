<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta de Divisas</title>

    <x-head />  <!--HEAD DEL SISTEMA-->
    
    <link rel="stylesheet" href="{{asset('styles/transferir.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/transferir.css">
    
    <x-temas />

</head>
<body>
    <div class="dashboard-container">

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Venta de Divisas</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <x-alertas_bootstrap />

            <div class="content-area">
                    <div class="transferencia-container">
                        @if ($i > 0) 
                            <form id="transferencia-form" method="POST" action="{{route('storeVenta')}}"
                            data-precio-dolar="{{ $monedas->precio ?? 0 }}">

                                @csrf

                                <div class="form-group">
                                    <label for="cuentaTypeLoginInput">Cuenta a Debitar:</label>
                                    <select id="cuentaTypeLoginInput" name="cuentaTypeLogin" class="@error('cuentaTypeLogin') is-invalid @enderror" required>
                                        <option value="">Seleccionar su cuenta</option>
                                        @foreach ($cuentasDolar as $cuentaDolar)
                                            @if ($cuentaDolar->cuentaType == 1)
                                                <option value="1">Cuenta Corriente = {{$cuentaDolar->availableBalance}} $.</option>
                                            @else
                                                <option value="2">Cuenta de Ahorro = {{$cuentaDolar->availableBalance}} $.</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <hr style="margin: 15px 0">

                                <div class="form-group">
                                    <label for="precio-dolar">Precio de Venta:</label>
                                    <h3 id="precio-dolar" style="text-align: center; margin: 0;">{{$monedas->precio}} $</h3>
                                </div>

                                <hr style="margin: 15px 0">

                                <div class="form-group">
                                    <label for="moneyInput">Cantidad de Dolares ($) a Vender:</label>
                                    <input type="number" step="0.01" id="moneyInput" class="@error('money') is-invalid @enderror" name="money" min="0.01" value="{{old('money')}}" required>
                                </div>

                                <div class="form-group">
                                    <label for="resultado-multiplicado">Cambio en Fritos:</label>
                                    <span id="resultado-multiplicado">0</span>
                                </div>

                                <input type="hidden" id="hidden-cantidad-bs" name="fritosTotal" value="0">

                                <div class="form-group">
                                    <label for="cuentaTypeLoginInput">Cuenta a Depositar:</label>
                                    <select id="cuentaTypeLoginInput" name="cuentaTypeDeposito" class="@error('cuentaTypeDeposito') is-invalid @enderror" required>
                                        <option value="">Seleccionar su cuenta</option>
                                        @foreach ($cuentasLogin as $cuentaLogin)
                                            @if ($cuentaLogin->cuentaType == 1)
                                                <option value="1">Cuenta Corriente = {{$cuentaLogin->availableBalance}} Fs.</option>
                                            @else
                                                <option value="2">Cuenta de Ahorro = {{$cuentaLogin->availableBalance}} Fs.</option>
                                            @endif
                                        @endforeach
                                        
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="conceptoInput">Concepto:</label>
                                    <input type="text" id="conceptoInput" name="concepto" class="@error('concepto') is-invalid @enderror" required>
                                </div>

                                <div class="form-group">
                                    <label for="passwordInput">Contraseña:</label>
                                    <input type="password" id="passwordInput" name="password" class="@error('password') is-invalid @enderror" required>
                                </div>

                                <button type="submit" class="transferir-button">Comprar Divisa</button>
                            </form>
                        @else
                            <h2>No se encuentran cuentas en dolares</h2>
                            <p style="text-align: center;">Solicitala Ya!   <a href="{{route('solicitudes.edit', Auth::user()->id)}}" style="text-decoration: none;">Click Aquí</a></p>
                        @endif
                        
                        
                    </div>
            </div>
        </main>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Obtener referencias a los elementos
        const form = document.getElementById('transferencia-form');
        const moneyInput = document.getElementById('moneyInput'); // Input de Dolares
        const resultadoDisplay = document.getElementById('resultado-multiplicado'); // Span para mostrar Bs
        const hiddenCantidadBs = document.getElementById('hidden-cantidad-bs'); // Input oculto
        const precioDolar = parseFloat(form.dataset.precioDolar); // Leer el precio del data attribute

        // 2. Función para calcular y actualizar
        function calcularPrecioEnBs() {
            // Obtener el valor ingresado por el usuario en Dolares
            const dolares = parseFloat(moneyInput.value);

            // Verificar si la entrada de dolares es un número válido y si el precio del dolar es válido
            if (!isNaN(dolares) && !isNaN(precioDolar) && dolares >= 0) {
                const resultado = dolares * precioDolar;

                // Mostrar el resultado al usuario (puedes formatearlo, ej: a 2 decimales)
                resultadoDisplay.textContent = resultado.toFixed(2) + ' Fs.'; // Muestra con 2 decimales y la unidad
                // Actualizar el valor del input oculto
                hiddenCantidadBs.value = resultado.toFixed(2); // Guarda el valor para enviar al backend

            } else {
                // Si la entrada no es válida o no es un número positivo
                resultadoDisplay.textContent = '0.00 Fs.';
                hiddenCantidadBs.value = '0'; // Asegura que el input oculto sea 0
            }
        }

        // 3. Ejecutar la función cuando el usuario escriba en el input de Dolares
        moneyInput.addEventListener('input', calcularPrecioEnBs);

        // 4. Ejecutar la función una vez al cargar la página por si el campo ya tiene un valor (ej: old())
        calcularPrecioEnBs();

        // Opcional: Puedes añadir un listener al evento 'change' también si quieres que se recalcule al perder el foco
        // moneyInput.addEventListener('change', calcularPrecioEnBs);
    });
</script>
</body>
</html>