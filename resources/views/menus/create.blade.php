<!-- create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Registrar Nuevo Menú</div>
        <div class="card-body">
            <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Menú</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" name="precio" id="precio" class="form-control" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen del Menú</label>
                    <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('menus.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection