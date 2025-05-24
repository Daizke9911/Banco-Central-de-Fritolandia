<?php 
use App\Models\Cuentas;

$cuentasDolar = Cuentas::where('user_id', Auth::user()->id)
->where('moneda', 'dolar')->get();

$i = 0;
foreach($cuentasDolar as $cuentaDolar){
    $i++;
}
?>

<aside class="sidebar">
    <div class="side-content">
        <div class="side-menu">
            <div class="logo"><img src="{{asset('files/logo_bcf.png')}}" class="logo-img"><p class="logo-p">BCF</p></div>
                <a href="{{route('dashboard')}}" class="active" title="Inicio"><span class="las la-lg la-home" style="margin: 0 3px 0 0"></span>
                    <span class="div-a">Inicio</span>
                </a>
                <a href="{{route('movimientos.index')}}" class="desactive" title="Movimientos"><span class="las la-lg la-table" style="margin: 0 3px 0 0"></span>
                    <span class="div-a">Movimientos</span>
                </a>
                <a href="{{route('tranferencia')}}" class="desactive" title="Transferencias"><span class="las la-lg la-long-arrow-alt-right" style="margin: 0 3px 0 0"></span>
                    <span class="div-a">Transferencias</span>
                </a>
                <a href="{{route('servicios.create')}}" class="desactive" title="Pago de Servicios"><span class="las la-lg la-id-card-alt" style="margin: 0 3px 0 0"></span>
                    <span class="div-a">Pago de Servicios</span>
                </a>
                <a href="{{route('buzon.index')}}" class="desactive" title="Buzon"><span class="las la-lg la-box-open" style="margin: 0 3px 0 0"></span>
                    <span class="div-a">Buzon</span>
                </a>
                <a href="{{route('sistema.index')}}" class="desactive" title="Sistema"><span class="las la-lg la-tools" style="margin: 0 3px 0 0"></span>
                    <span class="div-a">Sistema</span>
                </a>
                @if ($i > 0)
                    <hr>
                    <a href="{{route('tranferencia.dolar')}}" class="desactive" title="Transferencias en Dolares"><span class="las la-lg la-dollar-sign" style="margin: 0 3px 0 0"></span>
                        <span class="div-a">Transferencias en Dolares</span>
                    </a>
                    <a href="{{route('monedas.create')}}" class="desactive" title="Compra de Divisas"><span class="las la-lg la-money-bill-wave" style="margin: 0 3px 0 0"></span>C
                        <span class="div-a">ompra de Divisas</span>
                    </a>
                    <a href="{{route('createVenta')}}" class="desactive" title="Venta de Divisas"><span class="las la-lg la-money-bill" style="margin: 0 3px 0 0"></span>V
                        <span class="div-a">enta de Divisas</span>
                    </a>
                    <a href="{{route('monedas.index')}}" class="desactive" title="Historial de Divisas"><span class="las la-lg la-history" style="margin: 0 3px 0 0"></span>
                        <span class="div-a">Historial de Divisas</span>
                    </a>
                @endif
                @if (Auth::user()->role === "admin" || Auth::user()->role === "mod")
                    <hr>
                    <a href="{{route('usuarios.index')}}" class="desactive" title="Lista de Usuarios"><span class="las la-lg la-users" style="margin: 0 3px 0 0"></span>
                        <span class="div-a">Lista de Usuarios</span>
                    </a>
                @endif
                @if (Auth::user()->role === "admin" || Auth::user()->role === "mod")
                    <a href="{{route('solicitudes.index')}}" class="desactive" title="Solicitudes"><span class="las la-lg la-address-card" style="margin: 0 3px 0 0"></span>
                        <span class="div-a">Solicitudes</span>
                    </a>
                @endif
                @if (Auth::user()->role === "admin" || Auth::user()->id === 1)
                    <a href="{{route('reservas.index')}}" class="desactive" title="Reserva Bancaria"><span class="las la-lg la-piggy-bank" style="margin: 0 3px 0 0"></span>
                        <span class="div-a">Reserva Bancaria</span>
                    </a>
                @endif
        </div>
    </div>
</aside>

<script src="{{asset('js/sidebar.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/js/sidebar.js"></script>


