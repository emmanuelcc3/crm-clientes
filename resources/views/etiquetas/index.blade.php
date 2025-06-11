@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Título y botones --}}
    <h1 class="mb-4">Listado de Etiquetas</h1>

    @if ($filtro !== 'eliminados')
        @can('etiquetas.crear')
            <a href="{{ route('etiquetas.create') }}" class="btn btn-primary mb-3">Agregar Etiqueta</a>
        @endcan
    @endif


    {{-- Filtro de estado --}}
    @can('etiquetas.restaurar')
    <form method="GET" action="{{ route('etiquetas.index') }}" class="mb-3">
        <select name="filtro" onchange="this.form.submit()" class="form-select w-auto">
            <option value="activos" {{ $filtro === 'activos' ? 'selected' : '' }}>Activos</option>
            <option value="eliminados" {{ $filtro === 'eliminados' ? 'selected' : '' }}>Eliminados</option>
            <option value="todos" {{ $filtro === 'todos' ? 'selected' : '' }}>Todos</option>
        </select>
    </form>
    @endcan
    {{-- Tabla de etiquetas --}}
    <div class="table-responsive">
        <table id="tabla-etiquetas" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($etiquetas as $etiqueta)
                <tr>
                    <td>{{ $etiqueta->nombre }}</td>
                    <td>
                        @if ($etiqueta->trashed())
                            @can('etiquetas.restaurar')
                                <form action="{{ route('etiquetas.restaurar', $etiqueta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" title="Restaurar">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            @endcan
                        @else

                            @can('etiquetas.editar')
                                <a href="{{ route('etiquetas.edit', $etiqueta->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endcan
                            @can('etiquetas.eliminar')
                                <form id="form-delete-{{ $etiqueta->id }}" action="{{ route('etiquetas.destroy', $etiqueta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $etiqueta->id }}" title="Eliminar">
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
    {{-- SweetAlert de éxito --}}
    @if(session('success'))
        <script>
            swal({
                title: "¡Éxito!",
                text: "{{ session('success') }}",
                icon: "success",
                button: "Aceptar",
            });
        </script>
    @endif

    {{-- SweetAlert de error --}}
    @if(session('error'))
        <script>
            swal({
                title: "¡Error!",
                text: "{{ session('error') }}",
                icon: "error",
                button: "Aceptar",
            });
        </script>
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                const etiquetaId = this.getAttribute('data-id');

                swal({
                    title: "¿Estás seguro?",
                    text: "¡Esta acción no se puede deshacer!",
                    icon: "warning",
                    buttons: ["Cancelar", "Sí, eliminar"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        document.getElementById(`form-delete-${etiquetaId}`).submit();
                    }
                });
            });
        });
    });

    </script>

    {{-- Activar DataTables --}}
    <script>
        $(document).ready(function () {
            $('#tabla-etiquetas').DataTable({
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
