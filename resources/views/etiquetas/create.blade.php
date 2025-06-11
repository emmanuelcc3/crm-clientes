@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Etiqueta</h1>

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

    {{-- Formulario --}}
    <form method="POST" action="{{ route('etiquetas.store') }}">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre *</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>



        <div class="mt-4">
            <button type="submit" class="btn btn-success me-2">Guardar</button>
            <a href="{{ route('etiquetas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
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



<script>
    $(document).ready(function() {
        $('#etiquetas').select2({
            placeholder: "Selecciona una o varias etiquetas",
            allowClear: true,
            width: '100%'
        });
    });
</script>
    

@endpush

