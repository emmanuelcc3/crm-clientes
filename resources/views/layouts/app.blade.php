<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LUMÉ CRM') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    

</head>
<body>

    @auth
        <div class="d-flex">
            {{-- Sidebar --}}
            <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
                <h4 class="text-center">LUMÉ CRM</h4>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item"><a class="nav-link text-white" href="{{ url('/home') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('clientes.index') }}">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Productos</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Ventas</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Usuarios</a></li>
                </ul>
            </div>

            {{-- Contenido y navbar --}}
            <div class="p-4 w-100">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                    <div class="container-fluid">
                        <span class="navbar-text">
                            Bienvenido, {{ Auth::user()->name ?? 'Invitado' }}
                        </span>
                        <div class="ms-auto">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="btn btn-sm btn-outline-danger">
                                Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </nav>

                @yield('content')
            </div>
        </div>
    @endauth

    @guest
        {{-- Para login, register, etc. --}}
        <div class="container mt-5">
            @yield('content')
        </div>
    @endguest

    <!-- Scripts globales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')


</body>
</html>


