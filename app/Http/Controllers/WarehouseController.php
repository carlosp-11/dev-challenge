<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:warehouses,code',
            'name' => 'required|string|max:255'
        ], [
            'code.required' => 'El código es obligatorio',
            'code.unique' => 'El código ya existe en el sistema',
            'name.required' => 'El nombre del almacén es obligatorio',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'code.max' => 'El código no puede exceder 255 caracteres'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Warehouse::create([
                'code' => strtoupper(trim($request->code)),
                'name' => trim($request->name)
            ]);

            return redirect()->back()->with('ok', 'Almacén creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear el almacén: ' . $e->getMessage()]);
        }
    }
}
