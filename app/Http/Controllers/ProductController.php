<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku' => 'required|string|max:255|unique:products,sku',
            'name' => 'required|string|max:255'
        ], [
            'sku.required' => 'El SKU es obligatorio',
            'sku.unique' => 'El SKU ya existe en el sistema',
            'name.required' => 'El nombre del producto es obligatorio',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'sku.max' => 'El SKU no puede exceder 255 caracteres'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Product::create([
                'sku' => strtoupper(trim($request->sku)),
                'name' => trim($request->name)
            ]);

            return redirect()->back()->with('ok', 'Producto creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear el producto: ' . $e->getMessage()]);
        }
    }
}
