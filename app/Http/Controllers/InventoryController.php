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

        // Consulta base para stock por producto y almacén
        $stockByProductWarehouseQuery = DB::table('inventory_movements as im')
            ->select([
                'im.product_id',
                'im.warehouse_id',
                'p.name as product_name',
                'p.sku as product_sku',
                'w.name as warehouse_name',
                'w.code as warehouse_code',
                DB::raw('SUM(CASE WHEN im.type = "IN" THEN im.quantity ELSE 0 END) - SUM(CASE WHEN im.type = "OUT" THEN im.quantity ELSE 0 END) as stock')
            ])
            ->join('products as p', 'p.id', '=', 'im.product_id')
            ->join('warehouses as w', 'w.id', '=', 'im.warehouse_id')
            ->groupBy('im.product_id', 'im.warehouse_id', 'p.name', 'p.sku', 'w.name', 'w.code')
            ->having('stock', '>', 0); // Solo mostrar productos con stock positivo
            
        // Aplicar filtro de almacén si existe
        if ($request->filled('warehouse_filter')) {
            $stockByProductWarehouseQuery->where('im.warehouse_id', $request->warehouse_filter);
        }
        
        // Obtener resultados ordenados por nombre de producto
        $stockByProductWarehouse = $stockByProductWarehouseQuery
            ->orderBy('p.name')
            ->get();

        // Consulta base para stock total por producto
        $stockByProductQuery = DB::table('inventory_movements as im')
            ->select([
                'im.product_id',
                'p.name as product_name',
                'p.sku as product_sku',
                DB::raw('SUM(CASE WHEN im.type = "IN" THEN im.quantity ELSE 0 END) - SUM(CASE WHEN im.type = "OUT" THEN im.quantity ELSE 0 END) as total_stock')
            ])
            ->join('products as p', 'p.id', '=', 'im.product_id')
            ->groupBy('im.product_id', 'p.name', 'p.sku')
            ->having('total_stock', '>', 0);
            
        // Aplicar filtro de producto si existe
        if ($request->filled('product_filter')) {
            $stockByProductQuery->where('im.product_id', $request->product_filter);
            
            // Si hay un filtro de producto activo, queremos detallar el stock por almacén
            $productStockByWarehouse = DB::table('inventory_movements as im')
                ->select([
                    'im.warehouse_id',
                    'w.name as warehouse_name',
                    'w.code as warehouse_code',
                    DB::raw('SUM(CASE WHEN im.type = "IN" THEN im.quantity ELSE 0 END) - SUM(CASE WHEN im.type = "OUT" THEN im.quantity ELSE 0 END) as warehouse_stock')
                ])
                ->join('warehouses as w', 'w.id', '=', 'im.warehouse_id')
                ->where('im.product_id', $request->product_filter)
                ->groupBy('im.warehouse_id', 'w.name', 'w.code')
                ->having('warehouse_stock', '>', 0)
                ->orderBy('w.name')
                ->get();
        } else {
            $productStockByWarehouse = collect(); // Colección vacía si no hay filtro
        }
        
        // Obtener resultados ordenados por nombre de producto
        $stockByProduct = $stockByProductQuery
            ->orderBy('p.name')
            ->get();

        // Estadísticas generales
        $totalProducts = Product::count();
        $totalWarehouses = Warehouse::count();
        $totalMovements = InventoryMovement::count();
        $totalStock = $stockByProduct->sum('total_stock');

        // Obtener datos para la pestaña activa
        $activeTab = $request->input('tab', 'movements');

        return view('inventory', compact(
            'products', 
            'warehouses', 
            'movements', 
            'stockByProductWarehouse', 
            'stockByProduct',
            'totalProducts',
            'totalWarehouses', 
            'totalMovements',
            'totalStock',
            'activeTab',
            'productStockByWarehouse'
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
