<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Divisas</title>
    
    <x-head />  <!--HEAD DEL SISTEMA-->

    <link rel="stylesheet" href="{{asset('styles/index_movimientos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/index_movimientos.css">
    <link rel="stylesheet" href="{{asset('styles/index_buzon.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/index_buzon.css">
    
    <x-temas />
</head>
<body>
    <div class="dashboard-container">
        
        <x-sidebar />  <!--SIDEBAR-->
        
        <x-alertas />

        <main class="main-content">
            <header>
                <h1>Historial de Compra y Venta de Divisas</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <div class="content-area">
                @if ($i > 0) 
                    <table id="tabla-movimientos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Monto Compra</th>
                                <th>Moneda</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody-movimientos">
                            @foreach ($historials as $historial)
                                <tr>
                                    <td>{{$historial->id}}</td>
                                    <td>{{\Carbon\Carbon::parse($historial->created_at)->format('d/m/Y H:i:s')}}</td>
                                    <td style="color: green;font-weight: bold;">{{$historial->compra}}</td>
                                    <td>{{$historial->monedaCompra}}</td>
                                    <td>
                                        <form action="{{route('monedas.show', $historial->id)}}" method="POST">
                                            @csrf
                                            @method('GET')
                                            <button type="submit" class="boton-info">Más Información</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-pagination :users="$historials"/>
                 @else
                    <h2>No se encuentran cuentas en dolares</h2>
                    <p style="text-align: center;">Solicitala Ya!   <a href="{{route('solicitudes.edit', Auth::user()->id)}}" style="text-decoration: none;">Click Aquí</a></p>
                @endif

               

            </div>
        </main>
    </div>
</body>
</html>