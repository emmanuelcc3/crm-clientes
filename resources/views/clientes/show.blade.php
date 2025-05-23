@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalle del Cliente</h1>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $cliente->nombre }}</h4>
            <p><strong>Correo:</strong> {{ $cliente->correo ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? 'N/A' }}</p>
            <p><strong>Dirección:</strong> {{ $cliente->direccion ?? 'N/A' }}</p>
            <p><strong>Etiquetas:</strong> {{ $cliente->etiquetas ?? 'Ninguna' }}</p>
        </div>
    </div>

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary mt-3">← Volver</a>
</div>
@endsection
