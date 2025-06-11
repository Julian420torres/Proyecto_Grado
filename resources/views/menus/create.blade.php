@extends('layouts.app')

@section('title', 'Crear Menú')

@push('css')
    <style>
        #descripcion {
            resize: none;
        }
    </style>
@endpush

@section('content')

    @include('layouts.partials.alert')

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Menú</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('menus.index') }}">Menús</a></li>
            <li class="breadcrumb-item active">Crear Menú</li>
        </ol>

        <div class="card">
            <div class="card-header">Registrar Nuevo Menú</div>
            <div class="card-body">
                <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="nombre" class="form-label">Nombre del Menú</label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" name="precio" id="precio" class="form-control" step="0.01"
                                value="{{ old('precio') }}" required>
                            @error('precio')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="imagen" class="form-label">Imagen del Menú</label>
                            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*"
                                required>
                            @error('imagen')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer text-center mt-4">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('menus.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
