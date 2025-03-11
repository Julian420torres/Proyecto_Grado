<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.create');
    }

    public function edit(Menu $menu)
{
    return view('menus.edit', compact('menu'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('menus', 'public');
        }

        Menu::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagen' => $imagenPath,
        ]);

        return redirect()->route('menus.index')->with('success', 'Menú agregado correctamente.');
    }

    public function update(Request $request, Menu $menu)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Si hay una nueva imagen, la almacenamos y eliminamos la anterior
    if ($request->hasFile('imagen')) {
        // Eliminar imagen anterior si existe
        if ($menu->imagen) {
            Storage::disk('public')->delete($menu->imagen);
        }

        // Guardar nueva imagen
        $menu->imagen = $request->file('imagen')->store('menus', 'public');
    }

    // Actualizar datos del menú
    $menu->update([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'precio' => $request->precio,
        'imagen' => $menu->imagen, 
    ]);

    return redirect()->route('menus.index')->with('success', 'Menú actualizado correctamente');
}

public function destroy(Menu $menu)
{
    // Eliminar la imagen si existe
    if ($menu->imagen) {
        Storage::disk('public')->delete($menu->imagen);
    }

    // Eliminar el menú
    $menu->delete();

    return redirect()->route('menus.index')->with('success', 'Menú eliminado correctamente');
}

    
}
