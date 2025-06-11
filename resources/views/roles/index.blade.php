@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Roles</h1>
    @can('roles.crear')
    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Crear nuevo rol</a>
    @endcan

    {{-- Mensajes de éxito o error --}}


    <div class="table-responsive">
        <table id="tabla-roles" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Permisos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach($role->permissions as $permiso)
                            <span class="badge bg-info text-dark">{{ $permiso->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @can('roles.editar')
                        @if($role->name !== 'admin')
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @else
                        <span class = "text-muted">No editable</span>
                        @endif
                        @endcan
                        @can('roles.eliminar')
                        @if($role->name !== 'admin')
                        <form action="{{ route('roles.destroy', $role->id) }}"method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                        @endcan
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
                const rolId = this.getAttribute('data-id');

                swal({
                    title: "¿Estás seguro?",
                    text: "¡Esta acción no se puede deshacer!",
                    icon: "warning",
                    buttons: ["Cancelar", "Sí, eliminar"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        document.getElementById(`form-delete-${rolId}`).submit();
                    }
                });
            });
        });
    });

    </script>


    {{-- Activar DataTables --}}
    <script>
        $(document).ready(function () {
            $('#tabla-roles').DataTable({
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