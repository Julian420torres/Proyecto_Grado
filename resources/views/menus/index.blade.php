@extends('layouts.app')

@section('title', 'Menús')

@push('css-datatable')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

    @include('layouts.partials.alert')

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Menús</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Menús</li>
        </ol>

        <div class="mb-4">
            <a href="{{ route('menus.create') }}">
                <button type="button" class="btn btn-primary">Añadir nuevo registro</button>
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Menús
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped fs-6">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr>
                                <td>{{ $menu->id }}</td>
                                <td>{{ $menu->nombre }}</td>
                                <td>${{ number_format($menu->precio, 2) }}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <div>
                                            <button title="Opciones"
                                                class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu text-bg-light" style="font-size: small;">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#verModal-{{ $menu->id }}">Ver</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('menus.edit', $menu->id) }}">Editar</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <div class="vr"></div>
                                        </div>
                                        <div>
                                            <button title="Eliminar" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $menu->id }}"
                                                class="btn btn-datatable btn-icon btn-transparent-dark">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Ver -->
                            <div class="modal fade" id="verModal-{{ $menu->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del Menú</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <img src="{{ asset('storage/' . $menu->imagen) }}"
                                                    alt="{{ $menu->nombre }}"
                                                    class="img-fluid img-thumbnail border border-4 rounded"
                                                    style="max-width: 100%; height: auto;">
                                            </div>
                                            <div class="col-12">
                                                <p><span class="fw-bolder">Código: </span>{{ $menu->id }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p><span class="fw-bolder">Nombre: </span>{{ $menu->nombre }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p><span class="fw-bolder">Descripción: </span>{{ $menu->descripcion }}</p>
                                            </div>
                                            <div class="col-12">
                                                <p><span class="fw-bolder">Precio:
                                                    </span>${{ number_format($menu->precio, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Confirmación Eliminar -->
                            <div class="modal fade" id="confirmModal-{{ $menu->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Seguro que deseas eliminar el menú?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('menus.destroy', $menu->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
