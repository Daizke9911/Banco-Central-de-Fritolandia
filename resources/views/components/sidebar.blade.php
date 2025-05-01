<aside class="sidebar">
    <div class="side-content">
        <div class="side-menu">
            <div class="logo">Banco Central de Fritolandia</div>
                <a href="{{route('dashboard')}}" class="active">Inicio</a>
                <a href="{{route('movimientos.index')}}" class="desactive">Movimientos</a>
                <a href="{{route('tranferencia')}}" class="desactive">Transferencias</a>
                <a href="{{route('servicios.create')}}" class="desactive">Pago de Servicios</a>
                @if (Auth::user()->role === "admin" || Auth::user()->role === "mod")
                <a href="{{route('usuarios.index')}}" class="desactive">Lista de Usuarios</a> 
                @endif
                <a href="{{route('sistema.index')}}" class="desactive">Sistema</a>
        </div>
    </div>
</aside>

<script src="{{asset('js/sidebar.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/Daizke9911/Banco-Central-de-Fritolandia@master/public/js/sidebar.js"></script>


