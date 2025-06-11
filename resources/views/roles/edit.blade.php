@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Rol: {{ $role->name }}</h1>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Nombre del Rol</label>
            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
        </div>

        <h5>Permisos</h5>
        <div class="row">
            @php
                $agrupados = $permissions->groupBy(function($permiso) {
                    return explode('.', $permiso->name)[0];
                });
            @endphp

            @foreach($agrupados as $grupo => $permisos)
                <div class="col-md-4 mb-3">
                    <strong>{{ ucfirst($grupo) }}</strong><br>
                    @foreach($permisos as $permiso)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permiso->name }}"
                                   id="permiso-{{ $permiso->id }}"
                                   {{ $role->permissions->contains('name', $permiso->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permiso-{{ $permiso->id }}">{{ explode('.', $permiso->name)[1] ?? $permiso->name }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success">Actualizar Rol</button>
    </form>
</div>
@endsection
