<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tranferencias</title>
    <link rel="stylesheet" href="{{asset('styles/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('styles/transferir.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/styles_BCF@master/public/styles/transferir.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/styles_BCF@master/public/styles/dashboard.css">
    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Realizar Transferencia</h1>
                <div class="user-info">
                    <a class="logout-btn" href="{{route('logout')}}" onclick="localStorage.removeItem('activeSidebarRoute');">Cerrar Sesión</a>
                </div>
            </header>

            <x-alertas_bootstrap />

            <div class="content-area">
                <section id="transferencias-section" class="transferencias-section active">
                    <div class="transferencia-container">
                        <form id="transferencia-form" method="POST" action="{{route('movimientos.store')}}">
                            
                            @csrf
                            

                            <div class="form-group">
                                <label for="cuentaTypeLoginInput">Cuenta a Debitar:</label>
                                <select id="cuentaTypeLoginInput" name="cuentaTypeLogin" class="@error('cuentaTypeLogin') is-invalid @enderror" required>
                                    <option value="">Seleccionar su cuenta</option>
                                    @foreach ($cuentasLogin as $cuentaLogin)
                                        @if ($cuentaLogin->cuentaType == 1)
                                            <option value="1">Cuenta Corriente = {{$cuentaLogin->availableBalance}} Bs.</option>
                                        @else
                                            <option value="2">Cuenta de Ahorro = {{$cuentaLogin->availableBalance}} Bs.</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <hr style="margin: 15px 0">
                
                            <div class="form-group">
                                <label for="cedulaInput">Cédula:</label>
                                <input type="text" id="cedulaInput" name="cedula" class="@error('cedula') is-invalid @enderror" pattern="[0-9]+" title="Ingrese solo números" value="{{old('cedula')}}" required>
                               
                            </div>
                
                            <div class="form-group">
                                <label for="phoneInput">Teléfono:</label>
                                <input type="tel" id="phoneInput" name="phone" class="@error('phone') is-invalid @enderror" pattern="[0-9]+" title="Ingrese solo números" value="{{old('phone')}}" required>
                                
                            </div>
                
                            <div class="form-group">
                                <label for="moneyInput">Monto a Transferir (Bs):</label>
                                <input type="number" step="0.01" id="moneyInput" class="@error('money') is-invalid @enderror" name="money" min="0.01" value="{{old('money')}}" required>
                            
                            </div>
                
                            <div class="form-group">
                                <label for="cuentaTypeInput">Cuenta de Destino:</label>
                                <select id="cuentaTypeInput" name="cuentaType" class="@error('cuentaType') is-invalid @enderror" required>
                                    <option value="">Seleccionar tipo de cuenta</option>
                                    <option value="1">Cuenta Corriente</option>
                                    <option value="2">Cuenta de Ahorro</option>
                                </select>''
                            </div>
                
                            <div class="form-group">
                                <label for="conceptoInput">Concepto:</label>
                                <textarea id="conceptoInput" name="concepto" class="@error('concepto') is-invalid @enderror" rows="3" cols="10" maxlength="30" required>{{old('concepto')}}</textarea>
                               
                            </div>
                
                            <div class="form-group">
                                <label for="passwordInput">Contraseña:</label>
                                <input type="password" id="passwordInput" name="password" class="@error('password') is-invalid @enderror" required>
                               
                            </div>

                            <p>Cada transacción tiene un interes del 2%</p>

                            <button type="submit" class="transferir-button">Transferir</button>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>
    </body>
</html>