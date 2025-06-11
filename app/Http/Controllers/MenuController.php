<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Log;

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
        // Debug: Ver qué datos llegan
        Log::info('Datos recibidos:', $request->all());

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagenPath = null;
            if ($request->hasFile('imagen')) {
                $imagenPath = $request->file('imagen')->store('menus', 'public');
                Log::info('Imagen guardada en:', ['path' => $imagenPath]);
            }

            $menu = Menu::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'imagen' => $imagenPath,
            ]);

            Log::info('Menú creado:', ['id' => $menu->id, 'datos' => $menu->toArray()]);

            return redirect()->route('menus.index')->with('success', 'Menú agregado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear menú:', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['error' => 'Error al guardar el menú: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Menu $menu)
    {
        // Debug: Ver qué datos llegan
        Log::info('Datos para actualizar:', $request->all());
        Log::info('Menú a actualizar:', ['id' => $menu->id]);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $datosActualizar = [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
            ];

            // Si hay una nueva imagen, la almacenamos y eliminamos la anterior
            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($menu->imagen && Storage::disk('public')->exists($menu->imagen)) {
                    Storage::disk('public')->delete($menu->imagen);
                    Log::info('Imagen anterior eliminada:', ['path' => $menu->imagen]);
                }

                // Guardar nueva imagen
                $datosActualizar['imagen'] = $request->file('imagen')->store('menus', 'public');
                Log::info('Nueva imagen guardada:', ['path' => $datosActualizar['imagen']]);
            }

            // Actualizar datos del menú
            $menu->update($datosActualizar);

            Log::info('Menú actualizado:', ['id' => $menu->id, 'datos' => $menu->fresh()->toArray()]);

            return redirect()->route('menus.index')->with('success', 'Menú actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar menú:', ['error' => $e->getMessage(), 'menu_id' => $menu->id]);
            return back()->withInput()->withErrors(['error' => 'Error al actualizar el menú: ' . $e->getMessage()]);
        }
    }

    public function destroy(Menu $menu)
    {
        try {
            // Eliminar la imagen si existe
            if ($menu->imagen && Storage::disk('public')->exists($menu->imagen)) {
                Storage::disk('public')->delete($menu->imagen);
                Log::info('Imagen eliminada:', ['path' => $menu->imagen]);
            }

            // Eliminar el menú
            $menu->delete();

            Log::info('Menú eliminado:', ['id' => $menu->id]);

            return redirect()->route('menus.index')->with('success', 'Menú eliminado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar menú:', ['error' => $e->getMessage(), 'menu_id' => $menu->id]);
            return back()->withErrors(['error' => 'Error al eliminar el menú: ' . $e->getMessage()]);
        }
    }
}
