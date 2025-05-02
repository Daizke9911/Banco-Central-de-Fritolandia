<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Servicio</title>
    <link rel="stylesheet" href="estilos-generales.css">
    <link rel="stylesheet" href="{{asset('styles/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('styles/create_servicios.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/styles_BCF@master/styles/create_servicios.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/styles_BCF@master/styles/dashboard.css">
    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Pago de Servicios</h1>
                <div class="user-info">
                    <a class="logout-btn" href="{{route('logout')}}" onclick="localStorage.removeItem('activeSidebarRoute');">Cerrar Sesión</a>
                </div>
            </header>

            <x-alertas_bootstrap />
            
            <div class="pagar-servicio-container" id="pagarServicioContainer" data-cuentas="{{ json_encode($cuentasLogin) }}">

    <h2>Pagar Servicio</h2>

    <div class="seleccion-servicio">
        <h3>Seleccione el Servicio a Pagar:</h3>
        <p>Toda transacción tiene un interes del 2%</p>
        <select id="servicio-seleccionado">
            <option value="">-- Seleccionar --</option>
            <option value="telefonia">Pago de Teléfonia Movil</option>
            <option value="internet">Pago de Internet</option>
            <option value="servPublic">Servicios Publicos</option>
        </select>
    </div>

    <div id="formulario-servicio" class="formulario-servicio oculto">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const servicioSeleccionado = document.getElementById('servicio-seleccionado');
        const formularioServicio = document.getElementById('formulario-servicio');
        const pagarServicioContainer = document.getElementById('pagarServicioContainer');
        const cuentasLogin = JSON.parse(pagarServicioContainer.dataset.cuentas);

        servicioSeleccionado.addEventListener('change', function() {
            const servicio = this.value;
            formularioServicio.innerHTML = '';
            formularioServicio.classList.add('oculto');

            if (servicio === 'telefonia') {
                formularioServicio.classList.remove('oculto');
                formularioServicio.innerHTML = `
                    <form method="POST" action="{{route('servicios.store')}}">
                        @csrf
                        <h3>Pago de Telefonía</h3>
                        <div class="form-group">
                            <label for="select-yo">Elija una cuenta:</label>
                            <select class="select-yo" id="select-yo" name="cuentaTypeLogin2" class="@error('cuentaTypeLogin2') is-invalid @enderror">
                                <option value="">Seleccione una cuenta</option>
                                ${cuentasLogin.map(cuenta => `
                                    <option value="${cuenta.cuentaType}">
                                        ${cuenta.cuentaType == 1 ? 'Corriente' : 'Ahorro'} = ${cuenta.availableBalance} Bs.
                                    </option>
                                `).join('')}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="operadora_movil">Elija una operadora movil:</label>
                            <select class="select-yo" id="operadora_movil" name="operadora_movil" class="@error('operadora_movil') is-invalid @enderror">
                                <option value="">Seleccione una operadora</option>
                                <option value="0412">Digitel - 0412</option>
                                <option value="0414">Movistar - 0414</option>
                                <option value="0424">Movistar - 0424</option>
                                <option value="0416">Movilnet - 0416</option>
                                <option value="0426">Movilnet - 0426</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phoneInput">Número de Teléfono:</label>
                            <input type="tel" id="phoneInput" name="phone" class="@error('phone') is-invalid @enderror" required>

                        </div>
                        <div class="form-group">
                            <label for="montoInput">Seleccionar monto:</label>
                            <select class="select-yo" id="montoInput" name="monto" class="@error('monto') is-invalid @enderror">
                                <option value="">Seleccione un monto</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="150">150</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="500">500</option>
                                <option value="700">700</option>
                                <option value="1000">1000</option>
                                <option value="2000">2000</option>
                                <option value="999999999999">999999999999</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="passwordInput">Contraseña:</label>
                            <input type="password" id="passwordInput" name="password" class="@error('password') is-invalid @enderror" required>
                            @error('phone')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit">Pagar Telefonía</button>
                        </div>
                    </form>
                `;
            } else if (servicio === 'internet') {
                formularioServicio.classList.remove('oculto');
                formularioServicio.innerHTML = `
                    <form method="POST" action="{{route('servicios.store')}}">
                        @csrf
                        <h3>Pago de Internet</h3>
                        <div class="form-group">
                            <label for="select-yo">Elija una cuenta:</label>
                            <select class="select-yo" id="select-yo" name="cuentaTypeLogin2" class="@error('cuentaTypeLogin2') is-invalid @enderror">
                                <option value="">Seleccione una cuenta</option>
                                ${cuentasLogin.map(cuenta => `
                                    <option value="${cuenta.cuentaType}">
                                        ${cuenta.cuentaType == 1 ? 'Corriente' : 'Ahorro'} = ${cuenta.availableBalance} Bs.
                                    </option>
                                `).join('')}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="operadora_internetInput">Elija una operadora de internet:</label>
                            <select class="select-yo" id="operadora_internetInput" name="operadora_internet" class="@error('operadora_internet') is-invalid @enderror">
                                <option value="">Seleccione una operadora</option>
                                <option value="Cantv">Cantv</option>
                                <option value="Fibex">Fibex</option>
                                <option value="Tecnicable">Tecnicable</option>
                                <option value="Boom">Boom</option>
                                <option value="Intel">Intel</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="montoInput">Monto a Pagar (Bs):</label>
                            <input type="number" id="montoInput" name="monto" class="@error('monto') is-invalid @enderror" step="0.01" min="0.01" value="{{old('monto')}}" required>
                           
                        </div>
                        <div class="form-group">
                            <label for="passwordInput">Contraseña:</label>
                            <input type="password" id="passwordInput" name="password" class="@error('password') is-invalid @enderror" required>
                            
                        </div>
                        <div class="form-group">
                            <button type="submit">Pagar Telefonía</button>
                        </div>
                    </form>
                `;
            } else if (servicio === 'servPublic') {
                formularioServicio.classList.remove('oculto');
                formularioServicio.innerHTML = `
                    <form method="POST" action="{{route('servicios.store')}}">
                        @csrf
                        <h3>Pago de Servicios Públicos</h3>
                        <div class="form-group">
                            <label for="select-yo">Elija una cuenta:</label>
                            <select class="select-yo" id="select-yo" name="cuentaTypeLogin2" class="@error('cuentaTypeLogin2') is-invalid @enderror">
                                <option value="">Seleccione una cuenta</option>
                                ${cuentasLogin.map(cuenta => `
                                    <option value="${cuenta.cuentaType}">
                                        ${cuenta.cuentaType == 1 ? 'Corriente' : 'Ahorro'} = ${cuenta.availableBalance} Bs.
                                    </option>
                                `).join('')}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="servicio_publicoInput">Elija un servicio público:</label>
                            <select class="select-yo" id="servicio_publicoInput" name="servicio_publico" class="@error('servicio_publico') is-invalid @enderror">
                                <option value="">Seleccione un servicio público</option>
                                <option value="Agua">Agua Yaracuy</option>
                                <option value="Corpoelec">Corpoelec</option>
                                <option value="Aseo">Aseo</option>
                                <option value="Gas">Gas Yaracuy</option>
                                <option value="Felicidad">Felicidad</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="montoInput">Monto a Pagar (Bs):</label>
                            <input type="number" id="montoInput" name="monto" step="0.01" min="0.01" value="{{old('monto')}}" class="@error('monto') is-invalid @enderror" required>
                            
                        </div>
                        <div class="form-group">
                            <label for="passwordInput">Contraseña:</label>
                            <input type="password" id="passwordInput" name="password" class="@error('password') is-invalid @enderror" required>
                            
                        </div>
                        <div class="form-group">
                            <button type="submit">Pagar Telefonía</button>
                        </div>
                    </form>
                `;
            }
        });
    });
</script>