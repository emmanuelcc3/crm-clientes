@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Rol</h1>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Nombre del Rol</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <h5>Permisos</h5>
        <div class="row">
            @php
                $agrupados = $permissions->groupBy(function($permiso) {
                    return explode('.', $permiso->name)[0]; // clientes.ver → clientes
                });
            @endphp

            @foreach($agrupados as $grupo => $permisos)
                <div class="col-md-4 mb-3">
                    <strong>{{ ucfirst($grupo) }}</strong><br>
                    @foreach($permisos as $permiso)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permiso->name }}" id="permiso-{{ $permiso->id }}">
                            <label class="form-check-label" for="permiso-{{ $permiso->id }}">{{ explode('.', $permiso->name)[1] ?? $permiso->name }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Crear Rol</button>
    </form>
</div>
@endsection
