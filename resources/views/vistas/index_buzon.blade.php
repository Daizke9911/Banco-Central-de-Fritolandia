<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzon</title>
    
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

        <main class="main-content">
            <header>
                <h1>Historial de Movimientos</h1>
                <div class="user-info">
                    <x-logout />    <!--LOGOUT-->
                </div>
            </header>

            <div class="content-area">
                
                <div class="div-tablas">
                    <h2>Buzon de Entrada</h2>
                    <table id="tabla-movimientos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Descripción</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody-movimientos">
                            @foreach ($entradas as $entrada)
                                <tr>
                                    <td>{{$entrada->id}}</td>
                                    <td>{{\Carbon\Carbon::parse($entrada->created_at)->format('d/m/Y H:i:s')}}</td>
                                    <td>{{$entrada->estado}}</td>
                                    <td>{{$entrada->descripcion}}</td>
                                    <td>
                                        <form action="{{route('buzon.show', $entrada->id)}}" method="POST">
                                            @csrf
                                            @method('GET')
                                            <button type="submit" class="boton-info">Más Información</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-pagination :users="$entradas"/>
                </div>
                

                <div class="div-tablas" style="margin-top: 10%;">
                    <h2>Buzon de Salida</h2>
                    <table id="tabla-movimientos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Descripción</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody-movimientos">
                            @foreach ($salidas as $salida)
                                <tr>
                                    <td>{{$salida->id}}</td>
                                    <td>{{\Carbon\Carbon::parse($salida->created_at)->format('d/m/Y H:i:s')}}</td>
                                    <td>{{$salida->estado}}</td>
                                    <td>{{$salida->descripcion}}</td>
                                    <td>
                                        <form action="{{route('buzon.show', $salida->id)}}" method="POST">
                                            @csrf
                                            @method('GET')
                                            <button type="submit" class="boton-info">Más Información</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-pagination :users="$salidas"/>
                </div>

            </div>
        </main>
    </div>
</body>
</html>