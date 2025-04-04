<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
{
    return [
        'fecha_hora' => 'required|date',
        'impuesto' => 'required|numeric|min:0',
        'numero_comprobante' => 'required|unique:ventas,numero_comprobante|max:255',
        'total' => 'required|numeric|min:0',
        'cliente_id' => 'required|exists:clientes,id',
        'user_id' => 'required|exists:users,id',
        'comprobante_id' => 'required|exists:comprobantes,id',

        // Productos
        'arrayidproducto' => 'nullable|array',
        'arrayidproducto.*' => 'required|exists:productos,id',
        'arraycantidadproducto' => 'nullable|array',
        'arraycantidadproducto.*' => 'required|integer|min:1',
        'arrayprecioventaproducto' => 'nullable|array',
        'arrayprecioventaproducto.*' => 'required|numeric|min:0',

        // Menús
        'arrayidmenu' => 'nullable|array',
        'arrayidmenu.*' => 'required|exists:menus,id',
        'arraycantidadmenu' => 'nullable|array',
        'arraycantidadmenu.*' => 'required|integer|min:1',
        'arrayprecioventamenu' => 'nullable|array',
        'arrayprecioventamenu.*' => 'required|numeric|min:0'
    ];
}
}
