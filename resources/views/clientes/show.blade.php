@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalle del Cliente</h1>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $cliente->nombre }}</h4>
            <p><strong>Correo:</strong> {{ $cliente->correo ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? 'N/A' }}</p>
            <p><strong>Etiquetas:</strong>
                @if ($cliente->etiquetas && $cliente->etiquetas->count())
                    @foreach ($cliente->etiquetas as $etiqueta)
                        <span class="badge bg-primary">{{ $etiqueta->nombre }}</span>
                    @endforeach
                @else
                    Ninguna
                @endif
            </p>


        </div>
    </div>

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary mt-3">← Volver</a>
</div>
@endsection
