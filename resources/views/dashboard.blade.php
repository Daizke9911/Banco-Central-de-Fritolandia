<?php 
use App\Models\Cuentas;
$saldos = Cuentas::where('user_id', Auth::user()->id)->get();

$total = 0;
$i = 0;
foreach ($saldos as $saldo) {
    $total = $saldo->availableBalance + $total;
    $i++;
}

//LOGICA DE GRAFICA

    $usuario = Auth::user();
    $cuentas = $usuario->cuenta()->get();

    $labels = [];
    $data = $cuentas->pluck('availableBalance')->toArray();

    foreach ($cuentas as $cuenta) {
        if ($cuenta->cuentaType == 1) {
            $labels[] = 'Corriente';
        } elseif ($cuenta->cuentaType == 2) {
            $labels[] = 'Ahorro';
        } else {
            $labels[] = 'Tipo Desconocido (' . $cuenta->cuentaType . ')'; // Manejo para otros tipos si existen
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <x-head />  <!--HEAD DEL SISTEMA-->

    <link rel="stylesheet" href="{{asset('styles/dashboard_grafia.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/styles_BCF@master/styles/dashboard_grafia.css">

    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Bienvenido de vuelta {{Auth::user()->name}}</h1>
                <div class="user-info">
                    <a class="logout-btn" href="{{route('logout')}}" onclick="localStorage.removeItem('activeSidebarRoute');">Cerrar Sesión</a>
                </div>
            </header>

            <div class="content-area">

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
                        @if ($i == 2)
                            <div class="widget">
                                <h3 style="color: green">Saldo Total</h3>
                                <span class="data">{{$total}} Bs.</span>
                            </div>
                        @endif
                        
                    </div>
                    <div>
                        <div class="chart">
                            <h3>Gráfico</h3>
                            <div class="chart-selector">
                                <button id="showPieChartBtn" class="chart-button active">Gráfico de Pastel</button>
                                <button id="showBarChartBtn" class="chart-button">Gráfico de Barras</button>
                                <button id="showDonutChartBtn" class="chart-button">Gráfico de Dona</button>
                            </div>
                            <div id="pieChartContainer" class="chart-container">
                                <h3>Distribución del Saldo en Pastel</h3>
                                <div id="pieChart"></div>
                            </div>
                            <div id="barChartContainer" class="chart-container" style="display: none;">
                                <h3>Distribución del Saldo en Barra</h3>
                                <div id="barChart"></div>
                            </div>
                            <div id="donutChartContainer" class="chart-container" style="display: none;">
                                <h3>Distribución del Saldo en Dona</h3>
                                <div id="donutChart"></div>
                            </div>
                    </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const pieChartContainer = document.querySelector("#pieChartContainer");
        const barChartContainer = document.querySelector("#barChartContainer");
        const donutChartContainer = document.querySelector("#donutChartContainer");
        const showPieChartBtn = document.querySelector("#showPieChartBtn");
        const showBarChartBtn = document.querySelector("#showBarChartBtn");
        const showDonutChartBtn = document.querySelector("#showDonutChartBtn");
        const chartButtons = document.querySelectorAll('.chart-button');

        // Datos para el gráfico de pastel y dona
        const pieChartLabels = @json($labels);
        const pieChartSeries = @json($data);

        // Datos para el gráfico de barras
        const barChartCategories = pieChartLabels;
        const barChartSeriesData = [{ name: 'Saldo', data: pieChartSeries }];

        let pieChartInstance = null;
        let barChartInstance = null;
        let donutChartInstance = null;

        function renderPieChart() {
            const options = {
                series: pieChartSeries,
                chart: { type: 'pie', height: 350 },
                labels: pieChartLabels,
                legend: { position: 'bottom' },
                responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }]
            };
            pieChartInstance = new ApexCharts(document.querySelector("#pieChart"), options);
            pieChartInstance.render();
        }

        function renderBarChart() {
            const options = {
                series: barChartSeriesData,
                chart: { type: 'bar', height: 350 },
                plotOptions: { bar: { horizontal: false, dataLabels: { position: 'top' } } },
                dataLabels: { enabled: true, offsetX: -6, style: { fontSize: '12px', colors: ['#fff'] } },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                xaxis: { categories: barChartCategories, title: { text: 'Tipo de Cuenta' } },
                yaxis: { title: { text: 'Saldo (Bs.)' } },
                fill: { opacity: 1 },
                tooltip: { y: { formatter: function (val) { return val + " Bs." } } }
            };
            barChartInstance = new ApexCharts(document.querySelector("#barChart"), options);
            barChartInstance.render();
        }

        function renderDonutChart() {
            const options = {
                series: pieChartSeries,
                chart: { type: 'donut', height: 350 },
                labels: pieChartLabels,
                legend: { position: 'bottom' },
                responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }]
            };
            donutChartInstance = new ApexCharts(document.querySelector("#donutChart"), options);
            donutChartInstance.render();
        }

        function handleChartSelection(chartType) {
            pieChartContainer.style.display = 'none';
            barChartContainer.style.display = 'none';
            donutChartContainer.style.display = 'none';

            chartButtons.forEach(button => button.classList.remove('active'));

            if (pieChartInstance) { pieChartInstance.destroy(); pieChartInstance = null; }
            if (barChartInstance) { barChartInstance.destroy(); barChartInstance = null; }
            if (donutChartInstance) { donutChartInstance.destroy(); donutChartInstance = null; }

            if (chartType === 'pie') {
                pieChartContainer.style.display = 'block';
                showPieChartBtn.classList.add('active');
                renderPieChart();
            } else if (chartType === 'bar') {
                barChartContainer.style.display = 'block';
                showBarChartBtn.classList.add('active');
                renderBarChart();
            } else if (chartType === 'donut') {
                donutChartContainer.style.display = 'block';
                showDonutChartBtn.classList.add('active');
                renderDonutChart();
            }
            // Agrega más condiciones 'else if' para otros tipos de gráficos
        }

        handleChartSelection('pie'); // Mostrar pastel por defecto

        showPieChartBtn.addEventListener('click', () => handleChartSelection('pie'));
        showBarChartBtn.addEventListener('click', () => handleChartSelection('bar'));
        showDonutChartBtn.addEventListener('click', () => handleChartSelection('donut'));
        // Agrega más event listeners para otros botones de gráficos
    });
</script>
    </script>

    </body>
</html>