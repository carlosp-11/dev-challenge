<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\InventoryMovement;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        // Obtener productos y almacenes para filtros y formularios
        $products = Product::all();
        $warehouses = Warehouse::all();

        // Consultar movimientos con filtros y paginación
        $movementsQuery = InventoryMovement::with(['product', 'warehouse'])
            ->orderBy('moved_at', 'desc');

        // Aplicar filtros si existen
        if ($request->filled('product_id')) {
            $movementsQuery->where('product_id', $request->product_id);
        }

        if ($request->filled('warehouse_id')) {
            $movementsQuery->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->filled('type')) {
            $movementsQuery->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $movementsQuery->where('moved_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $movementsQuery->where('moved_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Paginación de movimientos
        $movements = $movementsQuery->paginate(15)->appends($request->query());

        // Calcular stock por producto y almacén
        $stockByProductWarehouse = DB::table('inventory_movements as im')
            ->select([
                'im.product_id',
                'im.warehouse_id',
                'p.name as product_name',
                'p.sku as product_sku',
                'w.name as warehouse_name',
                DB::raw('SUM(CASE WHEN im.type = "IN" THEN im.quantity ELSE 0 END) - SUM(CASE WHEN im.type = "OUT" THEN im.quantity ELSE 0 END) as stock')
            ])
            ->join('products as p', 'p.id', '=', 'im.product_id')
            ->join('warehouses as w', 'w.id', '=', 'im.warehouse_id')
            ->groupBy('im.product_id', 'im.warehouse_id', 'p.name', 'p.sku', 'w.name')
            ->having('stock', '>', 0) // Solo mostrar productos con stock positivo
            ->orderBy('p.name')
            ->get();

        // Calcular stock total por producto
        $stockByProduct = DB::table('inventory_movements as im')
            ->select([
                'im.product_id',
                'p.name as product_name',
                'p.sku as product_sku',
                DB::raw('SUM(CASE WHEN im.type = "IN" THEN im.quantity ELSE 0 END) - SUM(CASE WHEN im.type = "OUT" THEN im.quantity ELSE 0 END) as total_stock')
            ])
            ->join('products as p', 'p.id', '=', 'im.product_id')
            ->groupBy('im.product_id', 'p.name', 'p.sku')
            ->having('total_stock', '>', 0)
            ->orderBy('p.name')
            ->get();

        // Estadísticas generales
        $totalProducts = Product::count();
        $totalWarehouses = Warehouse::count();
        $totalMovements = InventoryMovement::count();
        $totalStock = $stockByProduct->sum('total_stock');

        return view('inventory', compact(
            'products', 
            'warehouses', 
            'movements', 
            'stockByProductWarehouse', 
            'stockByProduct',
            'totalProducts',
            'totalWarehouses', 
            'totalMovements',
            'totalStock'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->inventoryService->registerMovement(
            $request->product_id,
            $request->warehouse_id,
            $request->type,
            $request->quantity,
            $request->reference
        );

        return redirect()->back()->with('ok', 'Movimiento registrado exitosamente.');
    }
}
