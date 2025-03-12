@extends('layouts.app')

@section('title','Realizar venta')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush


@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Realizar Venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ventas.index')}}">Ventas</a></li>
        <li class="breadcrumb-item active">Realizar Venta</li>
    </ol>
</div>

<form action="{{ route('ventas.store') }}" method="post">
    @csrf
    <div class="container-lg mt-4">
        <div class="row gy-4">

            <!------venta producto---->
            <div class="col-xl-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la venta
                </div>
                <div class="p-3 border border-3 border-primary">
                    <div class="row gy-4">

                        <!-- Selección de Producto -->
<div class="col-12">
    <label for="producto_id">Seleccionar Producto:</label>
    <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" data-size="1" title="Busque un producto aquí">
        @foreach ($productos as $item)
            <option value="{{$item->id}}" data-precio="{{$item->precio_venta}}" data-stock="{{$item->stock}}">
                {{$item->codigo.' '.$item->nombre}}
            </option>
        @endforeach
    </select>
</div>

<!-- Selección de Menú -->
<div class="form-group">
    <label for="menu_id">Seleccionar Menú:</label>
    <select name="menu_id" id="menu_id" class="form-control selectpicker" data-live-search="true" title="Busque un menú aquí">
        <option value="">Seleccione un menú</option>
        @foreach ($menus as $menu)
            <option value="{{$menu->id}}" data-precio="{{$menu->precio}}">
                {{$menu->nombre}}
            </option>
        @endforeach
    </select>
</div>

<!-- Precio del Producto -->
<div class="col-sm-4">
    <label for="precio_producto" class="form-label">Precio del Producto:</label>
    <input type="number" name="precio_producto" id="precio_producto" class="form-control" step="0.1" readonly>
</div>

<!-- Stock -->
<div class="col-sm-4">  
    <label for="stock" class="form-label">Stock:</label>   
    <input disabled id="stock" type="text" class="form-control" step='0.1' reandonly>
</div>


<!-- Precio del Menú -->
<div class="col-sm-4">
    <label for="precio_menu" class="form-label">Precio del Menú:</label>
    <input type="number" name="precio_menu" id="precio_menu" class="form-control" step="0.1" readonly>
</div>



<!-- Precio de Venta -->
<div class="col-sm-4">
    <label for="precio_venta" class="form-label">Precio de venta:</label>
    <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1" readonly>
</div>

<!-- Cantidad de Productos -->
<div class="col-sm-4">
    <label for="cantidad" class="form-label">Cantidad de productos:</label>
    <input type="number" name="cantidad" id="cantidad" class="form-control" min="0" value="0">
</div>

<!-- Cantidad de Platos del Menú -->
<div class="col-sm-4">
    <label for="cantidad_menu" class="form-label">Cantidad de Platos del Menú:</label>
    <input type="number" class="form-control" id="cantidad_menu" name="cantidad_menu" min="0" value="0">
</div>

                      

                        <!-----botón para agregar--->
                        <div class="col-12 text-end">
                            <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
                        </div>

                        <!-----Tabla para el detalle de la venta--->
                        <div class="col-12 flex-grow-1">
                            <div class="table-responsive" style="min-height: 250px; max-height: 500px; overflow-y: auto;">
                                <table id= "tabla_detalle" width="100%">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-white">#</th>
                                            <th class="text-white">Prod</th>
                                            <th class="text-white">#Prod</th>
                                            <th class="text-white">VProd</th>
                                            <th class="text-white">Menu</th>
                                            <th class="text-white">#Menu</th>
                                            <th class="text-white">VMenu</th>
                                            <th class="text-white">Subtotal</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="col-xl-8">
                                        <tr class="col-xl-8" >
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            
                                        </tr>
                                    </tbody>
                                    <tfoot>
    <tr>
        <th></th>
        <th colspan="4">Sumas</th>
        <th colspan="2"><span id="sumas">0</span></th>
    </tr>
    <tr>
        <th></th>
        <th colspan="4">INC (8%)</th>
        <th colspan="2"><span id="inc">0</span></th>
    </tr>
    <tr>
        <th></th>
        <th colspan="4">IVA (19%)</th>
        <th colspan="2"><span id="iva">0</span></th>
    </tr>
    <tr>
        <th></th>
        <th colspan="4">Total</th>
        <th colspan="2">
            <input type="hidden" name="total" value="0" id="inputTotal">
            <span id="total">0</span>
        </th>
    </tr>
</tfoot>
                                </table>
                            </div>
                        </div>

                        <!--Boton para cancelar venta--->
                        <div class="col-12">
                            <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Cancelar venta
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-----Venta---->
            <div class="col-xl-4">
                <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>
                <div class="p-3 border border-3 border-success">
                    <div class="row gy-4">
                        <!--Cliente-->
                        <div class="col-12">
                            <label for="cliente_id" class="form-label">Cliente:</label>
                            <select name="cliente_id" id="cliente_id" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona" data-size='2'>
                                @foreach ($clientes as $item)
                                <option value="{{$item->id}}">{{$item->persona->razon_social}}</option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                       <!-- Tipo de comprobante -->
<div class="col-12">
    <label for="comprobante_id" class="form-label">Comprobante:</label>
    <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker" title="Selecciona">
        <option value="">Seleccione</option> <!-- Opción vacía para obligar a seleccionar -->
        @foreach ($comprobantes as $item)
            <option value="{{ $item->id }}">{{ $item->tipo_comprobante }}</option>
        @endforeach
    </select>
    @error('comprobante_id')
        <small class="text-danger">{{ '*'.$message }}</small>
    @enderror
</div>

<!-- Número de comprobante -->
<div class="col-12">
    <label for="numero_comprobante" class="form-label">Número de comprobante:</label>
    <input required type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" readonly>
    @error('numero_comprobante')
        <small class="text-danger">{{ '*'.$message }}</small>
    @enderror
</div>

                        <!-- Impuesto -->
<div class="col-sm-6">
    <label for="impuesto" class="form-label">Total Impuesto:</label>
    <input readonly type="text" name="impuesto" id="impuesto" class="form-control border-success">
    @error('impuesto')
    <small class="text-danger">{{ '*'.$message }}</small>
    @enderror
</div>

<!-- Opciones de Impuesto -->
<div class="col-sm-6">
    <label class="form-label">Aplicar Impuestos:</label><br>
    <input type="checkbox" id="aplicar_inc"> INC (8%)  
    <input type="checkbox" id="aplicar_iva"> IVA (19%)  
</div>

                        <!--Fecha--->
                        <div class="col-sm-6">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input readonly type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d") ?>">
                            <?php

                            use Carbon\Carbon;

                            $fecha_hora = Carbon::now()->toDateTimeString();
                            ?>
                            <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">
                        </div>

                        <!----User--->
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <!--Botones--->
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success" id="guardar">Realizar venta</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para cancelar la venta -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Advertencia</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Seguro que quieres cancelar la venta?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btnCancelarVenta" type="button" class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

</form>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    
    let productoSelect, menuSelect, precioVentaInput, stockInput;
    $(document).ready(function() {

        $('#producto_id').change(mostrarValores);
        $('#btnCancelarVenta').click(function() {
            cancelarVenta();
        });

        disableButtons();

        // Inicializar los impuestos
        $('#impuesto').val('0');
        calcularImpuestos();

        // Detectar cambios en los checkbox de impuestos
        $('#aplicar_inc, #aplicar_iva').change(calcularImpuestos);
    });

    // Variables
    let cont = 0;
    let subtotal = [];
    let sumas = 0;
    let inc = 0;
    let iva = 0;
    let total = 0;

    // Constantes
    const incPorcentaje = 8;  // INC 8%
    const ivaPorcentaje = 19; // IVA 19%

    function mostrarValores() {
        let dataProducto = document.getElementById('producto_id').value.split('-');
        $('#stock').val(dataProducto[1]);
        $('#precio_venta').val(dataProducto[2]);
    }

    function calcularImpuestos() {
        let subtotalProductos = obtenerSubtotalProductos(); // Obtener subtotal de productos
        let subtotalMenus = obtenerSubtotalMenus(); // Obtener subtotal de menús

        // Aplicar impuestos según los checkbox seleccionados
        inc = $('#aplicar_inc').prop('checked') ? subtotalProductos * (incPorcentaje / 100) : 0;
        iva = $('#aplicar_iva').prop('checked') ? subtotalMenus * (ivaPorcentaje / 100) : 0;

        let totalImpuesto = inc + iva;

        // Mostrar los valores calculados
        $('#inc').text(inc.toFixed(2));
        $('#iva').text(iva.toFixed(2));
        $('#impuesto').val(totalImpuesto.toFixed(2));
    }

    function obtenerSubtotalProductos() {
        let total = 0;
        $('.producto-subtotal').each(function() {
            total += parseFloat($(this).text() || 0);
        });
        return total;
    }

    function obtenerSubtotalMenus() {
        let total = 0;
        $('.menu-subtotal').each(function() {
            total += parseFloat($(this).text() || 0);
        });
        return total;
    }

    function agregarProducto() {
    console.log("🚀 Intentando agregar producto...");

    // Variables de elementos del DOM
    const productoSelect = document.getElementById("producto_id");
    const menuSelect = document.getElementById("menu_id");
    const cantidadInput = document.getElementById("cantidad");
    const cantidadMenuInput = document.getElementById("cantidad_menu");
    const precioProductoInput = document.getElementById("precio_producto");
    const precioMenuInput = document.getElementById("precio_menu");
    const stockInput = document.getElementById("stock");
    const tablaDetalle = document.getElementById("tabla_detalle").getElementsByTagName("tbody")[0];

    if (!productoSelect || !menuSelect || !cantidadInput || !precioProductoInput || !precioMenuInput || !stockInput || !tablaDetalle || !cantidadMenuInput) {
        console.error("❌ Error: No se encontraron todos los elementos en el DOM.");
        return;
    }

    if (!productoSelect.value && !menuSelect.value) {
        alert("Debe seleccionar al menos un producto o un menú.");
        return;
    }

    let idProducto = productoSelect.value ? productoSelect.value : null;
    let idMenu = menuSelect.value ? menuSelect.value : null;
    let nameProducto = productoSelect.options[productoSelect.selectedIndex]?.text || "-";
    let nameMenu = menuSelect.options[menuSelect.selectedIndex]?.text || "-";
    let cantidadProducto = parseInt(cantidadInput.value) || 0;
    let cantidadMenu = parseInt(cantidadMenuInput.value) || 0;
    let precioProducto = parseFloat(precioProductoInput.value) || 0;
    let precioMenu = parseFloat(precioMenuInput.value) || 0;
    let stock = parseInt(stockInput.value) || 0;

    console.log("🔹 ID Producto:", idProducto);
    console.log("🔹 ID Menú:", idMenu);
    console.log("🔹 Cantidad Producto:", cantidadProducto);
    console.log("🔹 Cantidad Menú:", cantidadMenu);
    console.log("🔹 Precio Producto:", precioProducto);
    console.log("🔹 Precio Menú:", precioMenu);
    console.log("🔹 Stock:", stock);

    // Validaciones
    if (!idProducto && !idMenu) {
        showModal('⚠️ Debe seleccionar un producto o un menú.');
        return;
    }

    if (idProducto && cantidadProducto <= 0) {
        alert("Debe ingresar una cantidad válida de productos.");
        return;
    }

    if (idMenu && cantidadMenu <= 0) {
        alert("Debe ingresar una cantidad válida de menús.");
        return;
    }

    if (precioProducto <= 0 && precioMenu <= 0) {
        showModal('⚠️ El precio de venta debe ser mayor a 0.');
        return;
    }

    if (idProducto && cantidadProducto > stock) {
        showModal('❌ La cantidad ingresada supera el stock disponible.');
        return;
    }

    // Calcular precios y subtotal
    let subtotalProducto = cantidadProducto * precioProducto;
    let subtotalMenu = cantidadMenu * precioMenu;
    let subtotalVenta = subtotalProducto + subtotalMenu;
    
    subtotal[cont] = round(subtotalVenta);
    sumas += subtotal[cont];

    // Validar impuestos seleccionados
    let incAplicado = $("#aplicar_inc").is(":checked") ? round(subtotalProducto * 0.08) : 0;
    let ivaAplicado = $("#aplicar_iva").is(":checked") ? round(subtotalMenu * 0.19) : 0;

    inc = incAplicado;
    total = round(sumas + inc + ivaAplicado);

    console.log("🟢 Subtotal Producto:", subtotalProducto);
    console.log("🟢 Subtotal Menú:", subtotalMenu);
    console.log("🟢 INC Aplicado:", incAplicado);
    console.log("🟢 IVA Aplicado:", ivaAplicado);
    console.log("🟡 Evaluando botón de guardar...");
    console.log("🔹 Total actual:", total);

    // Crear la fila
    let fila = `<tr id="fila${cont}">`;
    fila += `<th>${cont + 1}</th>`;

    if (idProducto) {
        fila += `<td><input type="hidden" name="arrayidproducto[]" value="${idProducto}">${nameProducto}</td>`;
        fila += `<td><input type="hidden" name="arraycantidadproducto[]" value="${cantidadProducto}">${cantidadProducto}</td>`;
        fila += `<td><input type="hidden" name="arrayprecioventaproducto[]" value="${precioProducto}">${precioProducto}</td>`;
    } else {
        fila += `<td>-</td><td>-</td><td>-</td>`;
    }

    if (idMenu) {
        fila += `<td><input type="hidden" name="arrayidmenu[]" value="${idMenu}">${nameMenu}</td>`;
        fila += `<td><input type="hidden" name="arraycantidadmenu[]" value="${cantidadMenu}">${cantidadMenu}</td>`;
        fila += `<td><input type="hidden" name="arrayprecioventamenu[]" value="${precioMenu}">${precioMenu}</td>`;
    } else {
        fila += `<td>-</td><td>-</td><td>-</td>`;
    }

    fila += `<td><input type="hidden" name="arrayprecioventa[]" value="${subtotalVenta}">${subtotalVenta}</td>`;
    fila += `<td><button class="btn btn-danger" type="button" onClick="eliminarProducto(${cont})"><i class="fa-solid fa-trash"></i></button></td>`;
    fila += `</tr>`;

    // Agregar la fila a la tabla
    $('#tabla_detalle').append(fila);
    limpiarCampos();
    cont++;

    // Actualizar totales
    $('#sumas').html(sumas.toFixed(2));
    $('#inc').html(inc.toFixed(2));
    $('#iva').html(ivaAplicado.toFixed(2));
    $('#total').html(total.toFixed(2));
    $('#impuesto').val(inc.toFixed(2));
    $('#inputTotal').val(total.toFixed(2));

    console.log("🔹 Sumas:", sumas, "INC:", inc, "IVA:", ivaAplicado, "Total:", total);

    // Evaluar si mostrar botón
    disableButtons();
}





    function eliminarProducto(indice) {
        //Calcular valores
        sumas -= round(subtotal[indice]);
        inc = round(sumas / 100 * impuesto);
        total = round(sumas + inc);

        //Mostrar los campos calculados
        $('#sumas').html(sumas);
        $('#inc').html(inc);
        $('#total').html(total);
        $('#impuesto').val(inc);
        $('#InputTotal').val(total);

        //Eliminar el fila de la tabla
        $('#fila' + indice).remove();

        disableButtons();
    }

    function cancelarVenta() {
        //Elimar el tbody de la tabla
        $('#tabla_detalle tbody').empty();

        //Añadir una nueva fila a la tabla
        let fila = '<tr>' +
            '<th></th>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '</tr>';
        $('#tabla_detalle').append(fila);

        //Reiniciar valores de las variables
        cont = 0;
        subtotal = [];
        sumas = 0;
        inc = 0;
        total = 0;

        //Mostrar los campos calculados
        $('#sumas').html(sumas);
        $('#inc').html(inc);
        $('#total').html(total);
        $('#impuesto').val(impuesto + '%');
        $('#inputTotal').val(total);

        limpiarCampos();
        disableButtons();
    }

    function disableButtons() {
    console.log("🟡 Evaluando botón de guardar...");
    
    // Asegurar que 'total' tiene un valor válido
    if (isNaN(total) || total < 0) {
        total = 0;
    }

    console.log("🔹 Total actual:", total);

    if (total == 0) {
        console.log("❌ Ocultando botón de guardar");
        $('#guardar').hide();
        $('#cancelar').hide();
    } else {
        console.log("✅ Mostrando botón de guardar");
        $('#guardar').css("display", "block");  // Asegurar que se muestra
        $('#cancelar').css("display", "block");
    }
}

    function limpiarCampos() {
        let select = $('#producto_id');
        select.selectpicker('val', '');
        $('#cantidad').val('');
        $('#precio_venta').val('');
        
        $('#stock').val('');
    }

    function showModal(message, icon = 'error') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: icon,
            title: message
        })
    }

    function round(num, decimales = 2) {
        var signo = (num >= 0 ? 1 : -1);
        num = num * signo;
        if (decimales === 0) //con 0 decimales
            return signo * Math.round(num);
        // round(x * 10 ^ decimales)
        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
        // x * 10 ^ (-decimales)
        num = num.toString().split('e');
        return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
    }

    

  
    document.addEventListener("DOMContentLoaded", function () {
    console.log("🚀 DOM completamente cargado.");

    const productoSelect = document.getElementById("producto_id");
    const menuSelect = document.getElementById("menu_id");
    const precioProductoInput = document.getElementById("precio_producto");
    const precioMenuInput = document.getElementById("precio_menu");
    const stockInput = document.getElementById("stock");
    const precioVentaInput = document.getElementById("precio_venta");
    const cantidadProductoInput = document.getElementById("cantidad");
    const cantidadMenuInput = document.getElementById("cantidad_menu");

    // Verificar si los elementos existen
    if (!productoSelect || !menuSelect || !precioProductoInput || !precioMenuInput || !stockInput || !precioVentaInput || !cantidadProductoInput || !cantidadMenuInput) {
        console.error("❌ Error: No se encontraron algunos elementos en el DOM.");
        return;
    }

    console.log("✅ Selects de productos y menú encontrados.");

    // Función para actualizar los precios y stock
    function actualizarValores() {
    const productoSelect = document.getElementById("producto_id");
    const menuSelect = document.getElementById("menu_id");
    const cantidadProductoInput = document.getElementById("cantidad");
    const cantidadMenuInput = document.getElementById("cantidad_menu");
    const precioProductoInput = document.getElementById("precio_producto");
    const precioMenuInput = document.getElementById("precio_menu");
    const precioVentaInput = document.getElementById("precio_venta");
    const stockInput = document.getElementById("stock");

    let precioProducto = 0, precioMenu = 0, stockProducto = "";

    // Obtener datos del producto seleccionado
    if (productoSelect.value) {
        let productoSeleccionado = productoSelect.options[productoSelect.selectedIndex];
        precioProducto = parseFloat(productoSeleccionado.getAttribute("data-precio")) || 0;
        stockProducto = productoSeleccionado.getAttribute("data-stock") || "";
    }

    // Obtener datos del menú seleccionado
    if (menuSelect.value) {
        let menuSeleccionado = menuSelect.options[menuSelect.selectedIndex];
        precioMenu = parseFloat(menuSeleccionado.getAttribute("data-precio")) || 0;
    }

    // Mostrar precios y stock
    precioProductoInput.value = precioProducto.toFixed(2);
    precioMenuInput.value = precioMenu.toFixed(2);
    stockInput.value = stockProducto;

    // Calcular total correctamente
    let cantidadProducto = parseInt(cantidadProductoInput.value) || 0;
    let cantidadMenu = parseInt(cantidadMenuInput.value) || 0;
    let totalVenta = (precioProducto * cantidadProducto) + (precioMenu * cantidadMenu);
    precioVentaInput.value = totalVenta.toFixed(2);
}

    // Asignar eventos a los select y a los inputs de cantidad
    productoSelect.addEventListener("change", actualizarValores);
    menuSelect.addEventListener("change", actualizarValores);
    cantidadProductoInput.addEventListener("input", actualizarValores);
    cantidadMenuInput.addEventListener("input", actualizarValores);

    // Llamar a la función inicialmente para mostrar valores al cargar la página
    actualizarValores();
});

document.getElementById('comprobante_id').addEventListener('change', function() {
    let idComprobante = this.value;

    if (idComprobante) {
        fetch(`/ventas/obtener-numero-comprobante/${idComprobante}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('numero_comprobante').value = data.numero_comprobante;
        })
        .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('numero_comprobante').value = ''; // Si no selecciona, deja vacío
    }
});


    //Fuente: https://es.stackoverflow.com/questions/48958/redondear-a-dos-decimales-cuando-sea-necesario
</script>
@endpush