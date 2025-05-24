<?php 
use App\Models\Cuentas;
use App\Models\Monedas;
$saldos = Cuentas::where('user_id', Auth::user()->id)->get();
$monedas = Monedas::where('moneda', 'Dolar')->first();
$total = 0;
$totalDolar = 0;
$i = 0;
$d = 0;

foreach ($saldos as $saldo) {
    if ($saldo->moneda == "nacional") {
        $total = $saldo->availableBalance + $total;
        $i++;
    }elseif($saldo->moneda == "dolar"){
        $totalDolar = $saldo->availableBalance + $totalDolar;
        $d++;
    }
    
}

//LOGICA DE GRAFICA

    $usuario = Auth::user();
    $cuentas = $usuario->cuenta()->get();

    $labels = [];
    $data = [];
    $labelsDolar = [];
    $dataDolar = [];

    foreach ($cuentas as $cuenta) {
        if ($cuenta->moneda == "nacional") {
            $data[] = $cuenta->availableBalance;
        }elseif($cuenta->moneda == "dolar"){
            $dataDolar[] = $cuenta->availableBalance;
        }
    }

    foreach ($cuentas as $cuenta) {
        if ($cuenta->moneda == "nacional") {
            if ($cuenta->cuentaType == 1) {
                $labels[] = 'Fritos - Corriente';
            } elseif ($cuenta->cuentaType == 2) {
                $labels[] = 'Fritos - Ahorro';
            } else {
                $labels[] = 'Fritos Desconocidos (' . $cuenta->cuentaType . ')'; // Manejo para otros tipos si existen
            }
        }elseif($cuenta->moneda == "dolar"){
            if ($cuenta->cuentaType == 1) {
                $labelsDolar[] = 'Dolar - Corriente';
            } elseif ($cuenta->cuentaType == 2) {
                $labelsDolar[] = 'Dolar - Ahorro';
            } else {
                $labelsDolar[] = 'Dolars Desconocido (' . $cuenta->cuentaType . ')'; // Manejo para otros tipos si existen
            }
        }
        
    }

$bloqueo = false;
$bloqueoDos = false;
$bloqueoTres = false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <x-head />  <!--HEAD DEL SISTEMA-->

    <link rel="stylesheet" href="{{asset('styles/dashboard_grafia.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/dashboard_grafia.css">

    <x-temas />
</head>
<body>
    <div class="dashboard-container">

        <x-sidebar />  <!--SIDEBAR-->

        <main class="main-content">
            <header>
                <h1>Bienvenido de Vuelta "{{Auth::user()->name}}"</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <div class="div-precio-monedas">
                <h2>Dolar = </h2>
                <h3 id="precio-dolar-dashboard-compra">{{$monedas->precio}} $ // Compra</h3>
                <h2>-</h2>
                <h3 id="precio-dolar-dashboard-venta">{{$monedas->precio}} $ // Venta</h3>
            </div>

            <div class="content-area">
                
                    @foreach ($saldos as $saldo)
                        @if ($saldo->moneda == "nacional")
                            @if ($bloqueo == false)
                                
                                <div class="div-cartas-saldos">
                                    <h2>Moneda Nacional</h2>
                                    <h3>Fritos</h3>

                                    <?php $bloqueo = true; ?>

                                    <div class="widgets-grid">
                            @endif
                            
                            
                                @if ($saldo->cuentaType ==  1)
                                    <div class="widget">
                                        <h3>Cuenta Corriente</h3>
                                        <span class="data">{{$saldo->availableBalance}} Fs.</span>
                                    </div>
                                @else
                                    <div class="widget">
                                        <h3>Cuenta Ahorro</h3>
                                        <span class="data">{{$saldo->availableBalance}} Fs.</span>
                                    </div>
                                @endif 
                        @endif
                        
                    @endforeach

                    @if ($i == 2)
                        <div class="widget">
                            <h3 style="color: green">Saldo Total (Fs.)</h3>
                            <span class="data">{{$total}} Fs.</span>
                        </div>
                    @endif

                    </div>
                </div>

                <!--//////////dolar-->
                @if ($d)
                    <hr>

                    <div class="div-cartas-saldos">
                    <h2>Monedas Extranjeras</h2>
                @endif
                @foreach ($saldos as $saldo)
                        @if ($saldo->moneda == "dolar")
                            @if ($bloqueoDos == false)
                                
                                <h3>Dolar</h3>

                                <?php $bloqueoDos = true; ?>

                                <div class="widgets-grid">
                            @endif
                            
                            
                                @if ($saldo->cuentaType ==  1)
                                    <div class="widget">
                                        <h3>Cuenta Corriente</h3>
                                        <span class="data">{{$saldo->availableBalance}} $</span>
                                    </div>
                                @else
                                    <div class="widget">
                                        <h3>Cuenta Ahorro</h3>
                                        <span class="data">{{$saldo->availableBalance}} $</span>
                                    </div>
                                @endif 
                        @endif
                        
                    @endforeach

                    @if ($d == 2)
                        <div class="widget">
                            <h3 style="color: green">Saldo Total ($)</h3>
                            <span class="data">{{$totalDolar}} $</span>
                        </div>
                    @endif
                    
                    @if ($d)
                        </div>
                    @endif
                        
                </div>

                <!--///////////////////////////-->

                <hr>
                    <div class="chart-div">
                        <div class="chart">
                            <h3>Moneda Nacional / Fritos</h3>
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
                        @if ($d)
                            <div class="chart-dolar">
                            <h3>Moneda Extranjera / Dolar</h3>
                            <div class="chart-selector">
                                <button id="showPieChartBtnDolar" class="chart-button-dolar active-dolar">Gráfico de Pastel</button>
                                <button id="showBarChartBtnDolar" class="chart-button-dolar">Gráfico de Barras</button>
                                <button id="showDonutChartBtnDolar" class="chart-button-dolar">Gráfico de Dona</button>
                            </div>
                            <div id="pieChartContainerDolar" class="chart-container">
                                <h3>Distribución del Saldo en Pastel</h3>
                                <div id="pieChartDolar"></div>
                            </div>
                            <div id="barChartContainerDolar" class="chart-container" style="display: none;">
                                <h3>Distribución del Saldo en Barra</h3>
                                <div id="barChartDolar"></div>
                            </div>
                            <div id="donutChartContainerDolar" class="chart-container" style="display: none;">
                                <h3>Distribución del Saldo en Dona</h3>
                                <div id="donutChartDolar"></div>
                            </div>
                        </div>
                        @endif
                        
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
                yaxis: { title: { text: 'Saldo (Fs.)' } },
                fill: { opacity: 1 },
                tooltip: { y: { formatter: function (val) { return val + " Fs." } } }
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
@if ($d)
    <script>
        // DOLAR
        document.addEventListener('DOMContentLoaded', function() {
        const pieChartContainerDolar = document.querySelector("#pieChartContainerDolar");
        const barChartContainerDolar = document.querySelector("#barChartContainerDolar");
        const donutChartContainerDolar = document.querySelector("#donutChartContainerDolar");
        const showPieChartBtnDolar = document.querySelector("#showPieChartBtnDolar");
        const showBarChartBtnDolar = document.querySelector("#showBarChartBtnDolar");
        const showDonutChartBtnDolar = document.querySelector("#showDonutChartBtnDolar");
        const chartButtonsDolar = document.querySelectorAll('.chart-button-dolar');
    
        const pieChartLabelsDolar = @json($labelsDolar);
        const pieChartSeriesDolar = @json($dataDolar);
    
        const barChartCategoriesDolar = pieChartLabelsDolar;
        const barChartSeriesDataDolar = [{ name: 'Saldo', data: pieChartSeriesDolar }];
    
        let pieChartInstanceDolar = null;
        let barChartInstanceDolar = null;
        let donutChartInstanceDolar = null;
    
        function renderPieChartDolar() {
            const options = {
                series: pieChartSeriesDolar,
                chart: { type: 'pie', height: 350 },
                labels: pieChartLabelsDolar,
                legend: { position: 'bottom' },
                responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }]
            };
            pieChartInstanceDolar = new ApexCharts(document.querySelector("#pieChartDolar"), options);
            pieChartInstanceDolar.render();
        }

        function renderBarChartDolar() {
            const options = {
                series: barChartSeriesDataDolar,
                chart: { type: 'bar', height: 350 },
                plotOptions: { bar: { horizontal: false, dataLabels: { position: 'top' } } },
                dataLabels: { enabled: true, offsetX: -6, style: { fontSize: '12px', colors: ['#fff'] } },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                xaxis: { categories: barChartCategoriesDolar, title: { text: 'Tipo de Cuenta' } },
                yaxis: { title: { text: 'Saldo $' } },
                fill: { opacity: 1 },
                tooltip: { y: { formatter: function (val) { return val + " $" } } }
            };
            barChartInstanceDolar = new ApexCharts(document.querySelector("#barChartDolar"), options);
            barChartInstanceDolar.render();
        }

        function renderDonutChartDolar() {
            const options = {
                series: pieChartSeriesDolar,
                chart: { type: 'donut', height: 350 },
                labels: pieChartLabelsDolar,
                legend: { position: 'bottom' },
                responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }]
            };
            donutChartInstanceDolar = new ApexCharts(document.querySelector("#donutChartDolar"), options);
            donutChartInstanceDolar.render();
        }

        function handleChartSelectionDolar(chartTypeDolar) {
            pieChartContainerDolar.style.display = 'none';
            barChartContainerDolar.style.display = 'none';
            donutChartContainerDolar.style.display = 'none';

            chartButtonsDolar.forEach(button => button.classList.remove('active-dolar'));

            if (pieChartInstanceDolar) { pieChartInstanceDolar.destroy(); pieChartInstanceDolar = null; }
            if (barChartInstanceDolar) { barChartInstanceDolar.destroy(); barChartInstanceDolar = null; }
            if (donutChartInstanceDolar) { donutChartInstanceDolar.destroy(); donutChartInstanceDolar = null; }

            if (chartTypeDolar === 'pie') {
                pieChartContainerDolar.style.display = 'block';
                showPieChartBtnDolar.classList.add('active-dolar');
                renderPieChartDolar();
            } else if (chartTypeDolar === 'bar') {
                barChartContainerDolar.style.display = 'block';
                showBarChartBtnDolar.classList.add('active-dolar');
                renderBarChartDolar();
            } else if (chartTypeDolar === 'donut') {
                donutChartContainerDolar.style.display = 'block';
                showDonutChartBtnDolar.classList.add('active-dolar');
                renderDonutChartDolar();
            }
            // Agrega más condiciones 'else if' para otros tipos de gráficos
        }

        handleChartSelectionDolar('pie'); // Mostrar pastel por defecto

        showPieChartBtnDolar.addEventListener('click', () => handleChartSelectionDolar('pie'));
        showBarChartBtnDolar.addEventListener('click', () => handleChartSelectionDolar('bar'));
        showDonutChartBtnDolar.addEventListener('click', () => handleChartSelectionDolar('donut'));

        });
    </script>
@endif


    </body>
</html>