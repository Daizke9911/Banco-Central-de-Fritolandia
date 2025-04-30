<?php 
use App\Models\Cuentas;
$saldos = Cuentas::where('user_id', Auth::user()->id)->get();

$total = 0;
foreach ($saldos as $saldo) {
    $total = $saldo->availableBalance + $total;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="{{asset('styles/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/styles/dashboard.css">
    
    <script>
        window.sidebar = "{{ Auth::user()->tema->sidebar ?? null }}";
        window.buttonSidebar = "{{ Auth::user()->tema->button_sidebar ?? null }}";
        window.textColorSidebar = "{{ Auth::user()->tema->text_color_sidebar ?? null }}";
        window.backgraund = "{{ Auth::user()->tema->backgraund ?? null }}";
    </script>
</head>
<body>
    <div class="dashboard-container">

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Bienvenido de vuelta {{Auth::user()->name}}</h1>
                <div class="user-info">
                    <a class="logout-btn" href="{{route('logout')}}">Cerrar Sesión</a>
                </div>
            </header>
            <div class="content-area">
                <section id="overview-section" class="dashboard-section active">
                    <h2>Saldo Disponible</h2>
                    <div class="widgets-grid">
                        @foreach ($saldos as $saldo)
                            @if ($saldo->cuentaType ==  1)
                                <div class="widget">
                                    <h3>Cuenta Corriente</h3>
                                    <span class="data">{{$saldo->availableBalance}} Bs.</span>
                                </div>
                            @else
                                <div class="widget">
                                    <h3>Cuenta Ahorro</h3>
                                    <span class="data">{{$saldo->availableBalance}} Bs.</span>
                                </div>
                            @endif
                        @endforeach
                        <div class="widget">
                            <h3>Saldo Total</h3>
                            <span class="data">{{$total}} Bs.</span>
                        </div>
                        <div>
                            <div class="widget chart">
                                <h3>Gráfica</h3>
                                <canvas id="salesChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script src="{{asset('js/theme.js')}}"></script>
    </body>
</html>