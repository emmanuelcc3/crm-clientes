@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Título y botones --}}
    <h1 class="mb-4">Listado de Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">Agregar Cliente</a>

    {{-- Exportar --}}
    <div class="mb-3">
       <a href="{{ route('clientes.export.excel') }}" class="btn btn-success">Exportar Excel</a>
       <a href="{{ route('clientes.export.pdf') }}" class="btn btn-danger">Exportar PDF</a>
    </div>

    {{-- Tabla de clientes --}}
    <div class="table-responsive">
        <table id="tabla-clientes" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->correo }}</td>
                    <td>{{ $cliente->telefono }}</td>
                   <td>
                        <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-sm btn-info" title="Ver">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="tel:{{ $cliente->telefono }}" class="btn btn-sm btn-primary" title="Llamar">
                            <i class="bi bi-telephone"></i>
                        </a>
                        <a href="https://wa.me/506{{ $cliente->telefono }}" target="_blank" class="btn btn-sm btn-success" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
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
                const clienteId = this.getAttribute('data-id');

                swal({
                    title: "¿Estás seguro?",
                    text: "¡Esta acción no se puede deshacer!",
                    icon: "warning",
                    buttons: ["Cancelar", "Sí, eliminar"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        document.getElementById(`form-delete-${clienteId}`).submit();
                    }
                });
            });
        });
    });
</script>


    {{-- Activar DataTables --}}
    <script>
        $(document).ready(function () {
            $('#tabla-clientes').DataTable({
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
