<aside class="sidebar">
    <div class="logo">Banco Central de Fritolandia</div>
    <nav class="menu">
        <a href="{{route('dashboard')}}" class="active" data-section="overview">Inicio</a>
        <a href="{{route('movimientos.index')}}" data-section="movimientos">Movimientos</a>
        <a href="{{route('tranferencia')}}" data-section="transferencias">Transferencias</a>
        <a href="{{route('servicios.create')}}" data-section="servicios">Pago de Servicios</a>
        @if (Auth::user()->role === "admin" || Auth::user()->role === "mod")
           <a href="{{route('usuarios.index')}}" data-section="usuarios">Lista de Usuarios</a> 
        @endif
        <a href="{{route('sistema.index')}}" data-section="sistema">Sistema</a>
    </nav>
</aside>

