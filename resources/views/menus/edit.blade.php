@extends('layouts.app')

@section('title', 'Editar Menú')

@section('content')
<div class="container">
    <h1 class="mt-4 text-center">Editar Menú</h1>
    
    <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $menu->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', $menu->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio', $menu->precio) }}" required>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen actual:</label>
            <div>
                @if ($menu->imagen)
                    <img src="{{ asset('storage/'.$menu->imagen) }}" class="img-thumbnail" width="200">
                @else
                    <p>No hay imagen</p>
                @endif
            </div>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Nueva imagen (opcional):</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
