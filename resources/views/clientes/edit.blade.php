@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cliente</h1>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups! Hubo algunos errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre *</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $cliente->nombre) }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror"
                value="{{ old('correo', $cliente->correo) }}">
            @error('correo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono"  pattern="\d{8}" maxlength="8"  class="form-control @error('telefono') is-invalid @enderror"
                value="{{ old('telefono', $cliente->telefono) }}">
            @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea name="direccion" class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $cliente->direccion) }}</textarea>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="etiquetas">Etiquetas</label>
            <input type="text" name="etiquetas" class="form-control @error('etiquetas') is-invalid @enderror"
                value="{{ old('etiquetas', $cliente->etiquetas) }}">
            @error('etiquetas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary me-2">Actualizar</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
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
