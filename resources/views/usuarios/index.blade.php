@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Listado de Usuarios</h1>

    @can('usuarios.crear')
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Agregar Usuario</a>
    @endcan

    {{-- Filtro --}}
     @can('usuarios.restaurar')
    <form method="GET" action="{{ route('usuarios.index') }}" class="mb-3">
        <select name="filtro" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
            <option value="activos" {{ $filtro === 'activos' ? 'selected' : '' }}>Activos</option>
            <option value="eliminados" {{ $filtro === 'eliminados' ? 'selected' : '' }}>Eliminados</option>
            <option value="todos" {{ $filtro === 'todos' ? 'selected' : '' }}>Todos</option>
        </select>
    </form>
    @endcan

    <div class="table-responsive">
        <table id="tabla-usuarios" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        @forelse($usuario->roles as $rol)
                            <span class="badge bg-primary">{{ ucfirst($rol->name) }}</span>
                        @empty
                            <span class="badge bg-secondary">Sin rol</span>
                        @endforelse
                    </td>
                    <td>
                        @can('usuarios.editar')
                            @if(is_null($usuario->deleted_at))
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endif
                        @endcan

                            @if ($usuario->deleted_at)
                           @can('usuarios.restaurar')
                                <form action="{{ route('usuarios.restaurar', $usuario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" title="Restaurar">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            @endcan
                            @else
                            @can('usuarios.eliminar')
                                <form id="form-delete-{{ $usuario->id }}" action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $usuario->id }}" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                        @endcan
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
@if(session('success'))
    <script>
        swal("¡Éxito!", "{{ session('success') }}", "success");
    </script>
@endif

@if(session('error'))
    <script>
        swal("¡Error!", "{{ session('error') }}", "error");
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                swal({
                    title: "¿Estás seguro?",
                    text: "Esta acción no se puede deshacer.",
                    icon: "warning",
                    buttons: ["Cancelar", "Sí, eliminar"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        document.getElementById(`form-delete-${id}`).submit();
                    }
                });
            });
        });

        $('#tabla-usuarios').DataTable({
            "pageLength": 10,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros en total)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>
@endpush
