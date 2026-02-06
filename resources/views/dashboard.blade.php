<!DOCTYPE html>
<html lang="es">
<head>
    <title>Díaz Frontado - Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="dashboard-layout">
        <div class="sidebar">
            <img src="{{ asset('img/logo_df.jpg') }}" alt="Logo Díaz Frontado" class="sidebar-logo">
            <h2>Menú Principal</h2>
            <p>Sistema de Inventario</p>
            <hr>
            <a href="{{ route('dashboard') }}">Inicio / Bienvenida</a>
            <a href="{{ route('opcion.consultar') }}">Productos</a>
            <a href="{{ route('clients.index') }}">Clientes</a>
            <a href="{{ route('movements.index') }}">Movimientos</a>
            <a href="{{ route('opcion.reportes') }}">Reportes</a>
            
            @if (Auth::user() && Auth::user()->role == 'admin')
                <a href="{{ route('usuarios.index') }}">Gestión de Usuarios</a>
            @endif
            
            <hr>
            
            <a href="{{ route('login') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <div class="content">
            @if (session('success'))
                <script>
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                </script>
            @endif

            <h1>¡Bienvenido al Sistema de Inventario de Díaz Frontado, S.A.!</h1>
            
            @if (Request::is('sistema/dashboard'))
                <p class="slogan">Transportamos soluciones adaptadas a la necesidad de nuestros clientes!</p>
                
                <div class="dashboard-action-cards">
                    <a href="{{ route('movements.create') }}" class="action-card card-entrada">
                        <i class="fa-solid fa-plus-circle card-icon"></i>
                        <span class="card-title">Registrar Nueva Entrada</span>
                        <p class="card-description">Ingresa nuevos productos al inventario.</p>
                    </a>

                    <a href="{{ route('movements.createSalida') }}" class="action-card card-salida">
                        <i class="fa-solid fa-minus-circle card-icon"></i>
                        <span class="card-title">Registrar Nueva Salida</span>
                        <p class="card-description">Despacha productos a clientes.</p>
                    </a>

                    <a href="{{ route('opcion.consultar') }}" class="action-card card-consulta">
                        <i class="fa-solid fa-list-ul card-icon"></i>
                        <span class="card-title">Consultar Productos</span>
                        <p class="card-description">Ver el listado y stock de productos.</p>
                    </a>

                    <a href="{{ route('reportes.inventarioGeneral') }}" class="action-card card-reporte">
                         <i class="fa-solid fa-chart-pie card-icon"></i>
                        <span class="card-title">Ver Inventario General</span>
                        <p class="card-description">Genera el reporte de stock actual.</p>
                    </a>

                </div>

            @else
                 @yield('contenido')
            @endif

        </div>
    </div>

    <script src="{{ asset('js/scripts.js') }}"></script>
    @stack('styles') 
</body>
</html>