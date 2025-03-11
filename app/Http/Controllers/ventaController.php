<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\MenuVenta;
use App\Models\Menu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ventaController extends Controller{

    function __construct()
    {
        $this->middleware('permission:ver-venta|crear-venta|mostrar-venta|eliminar-venta', ['only' => ['index']]);
        $this->middleware('permission:crear-venta', ['only' => ['create', 'store']]);
        $this->middleware('permission:mostrar-venta', ['only' => ['show']]);
        $this->middleware('permission:eliminar-venta', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with(['comprobante','cliente.persona','user'])
        ->where('estado',1)
        ->latest()
        ->get();

        return view('venta.index',compact('ventas'));
    }

    public function obtenerNumeroComprobante($idComprobante)
{
    // Buscar la última venta con el mismo tipo de comprobante
    $ultimoComprobante = Venta::where('comprobante_id', $idComprobante)
                            ->orderBy('id', 'desc')
                            ->first();

    // Si hay un comprobante previo, sumamos 1 al número. Si no, comenzamos desde 1.
    $nuevoNumero = $ultimoComprobante ? $ultimoComprobante->numero_comprobante + 1 : 1;

    return response()->json(['numero_comprobante' => $nuevoNumero]);
}

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $subquery = DB::table('compra_producto')
        ->select('producto_id', DB::raw('MAX(created_at) as max_created_at'))
        ->groupBy('producto_id');

    $productos = Producto::join('compra_producto as cpr', function ($join) use ($subquery) {
            $join->on('cpr.producto_id', '=', 'productos.id')
                ->whereIn('cpr.created_at', DB::table(DB::raw("({$subquery->toSql()}) as subquery"))
                    ->select('subquery.max_created_at')
                    ->whereColumn('subquery.producto_id', 'cpr.producto_id')
                );
        })
        ->select('productos.nombre', 'productos.id', 'productos.stock', 'cpr.precio_venta')
        ->where('productos.estado', 1)
        ->where('productos.stock', '>', 0)
        ->get();

    $clientes = Cliente::whereHas('persona', function ($query) {
        $query->where('estado', 1);
    })->get();

    $comprobantes = Comprobante::all();
    $menus = Menu::all();

    return view('venta.create', compact('productos', 'clientes', 'comprobantes', 'menus'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request) {
        DB::enableQueryLog();
    
        try {
            DB::beginTransaction();
    
            // Crear la venta antes de asociarle productos y menús
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id ?? null,
                'comprobante_id' => $request->comprobante_id ?? null,
                'numero_comprobante' => $request->numero_comprobante ?? null,
                'impuesto' => floatval($request->impuesto ?? 0),
                'total' => floatval($request->total ?? 0),
                'fecha_hora' => now(),
                'user_id' => auth()->id(),
            ]);
    
            // Manejo de productos
            $arrayProducto_id = $request->get('arrayidproducto', []);
            $arrayCantidad = $request->get('arraycantidadproducto', []);
            $arrayPrecioVenta = $request->get('arrayprecioventaproducto', []);
    
            if (!empty($arrayProducto_id) && !empty($arrayCantidad)) {
                foreach ($arrayProducto_id as $index => $productoId) {
                    $cantidad = intval($arrayCantidad[$index] ?? 0);
                    $precioVenta = floatval($arrayPrecioVenta[$index] ?? 0);
    
                    // Verificar que el productoId no sea null o vacío
                    if (!empty($productoId) && $cantidad > 0) {
                        DB::table('producto_venta')->insert([
                            'venta_id' => $venta->id,
                            'producto_id' => $productoId,
                            'cantidad' => $cantidad,
                            'precio_venta' => $precioVenta,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
    
                        // Actualizar stock del producto
                        $producto = Producto::find($productoId);
                        if ($producto) {
                            $producto->stock -= $cantidad;
                            $producto->save();
                        }
                    }
                }
            }
    
            // Manejo de menús
            $arrayMenu_id = $request->get('arrayidmenu', []);
            $arrayCantidadMenu = $request->get('arraycantidadmenu', []);
            $arrayPrecioVentaMenu = $request->get('arrayprecioventamenu', []);
    
            if (!empty($arrayMenu_id) && !empty($arrayCantidadMenu)) {
                foreach ($arrayMenu_id as $index => $menuId) {
                    $cantidadMenu = intval($arrayCantidadMenu[$index] ?? 0);
                    $precioMenu = floatval($arrayPrecioVentaMenu[$index] ?? 0);
    
                    // Verificar que el menuId no sea null o vacío
                    if (!empty($menuId) && $cantidadMenu > 0) {
                        DB::table('menu_venta')->insert([
                            'venta_id' => $venta->id,
                            'menu_id' => $menuId,
                            'cantidad' => $cantidadMenu,
                            'precio_unitario' => $precioMenu,
                            'subtotal' => $cantidadMenu * $precioMenu,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
    
            DB::commit();
            return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    
        } catch (Exception $e) {
            DB::rollBack();
            dd("Error: " . $e->getMessage(), DB::getQueryLog());
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
{
    $venta->load(['productos', 'menus']); // Cargar las relaciones
    return view('venta.show', compact('venta'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Venta::where('id',$id)
        ->update([
            'estado' => 0
        ]);

        return redirect()->route('ventas.index')->with('success','Venta eliminada');
    }
}
