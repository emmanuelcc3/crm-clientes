@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="display-4">🚫 Acceso denegado</h1>
    <p>No tienes permisos para acceder a esta sección del sistema.</p>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
