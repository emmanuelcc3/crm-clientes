@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Editar Usuario</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" value="{{ $usuario->name }}" class="form-control" required>
        </div>

        @if(auth()->user()->hasRole('admin'))
            <div class="mb-3">
                <label>Correo Electrónico</label>
                <input type="email" name="email" value="{{ $usuario->email }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Nueva Contraseña (opcional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label>Rol</label>
                <select name="rol" class="form-control" required>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->name }}" {{ $usuario->hasRole($rol->name) ? 'selected' : '' }}>
                            {{ $rol->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            <input type="hidden" name="email" value="{{ $usuario->email }}">
        @endif

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection


@push('scripts')
    @if(session('success'))
        <script>
            swal({
                title: "¡Actualizado!",
                text: "{{ session('success') }}",
                icon: "success",
                button: "Aceptar",
            });
        </script>
    @endif
@endpush