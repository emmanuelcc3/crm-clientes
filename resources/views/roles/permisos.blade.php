@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Permisos para el rol: {{ $role->name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('roles.permisos.update', $role) }}">
        @csrf

        @foreach($permisos as $modulo => $acciones)
            <h5 class="mt-4">{{ ucfirst($modulo) }}</h5>
            <div class="row">
                @foreach($acciones as $permiso)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permiso->name }}"
                                {{ $role->hasPermissionTo($permiso->name) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{ ucfirst(str_replace($modulo . '.', '', $permiso->name)) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-4">Guardar Permisos</button>
    </form>
</div>
@endsection
