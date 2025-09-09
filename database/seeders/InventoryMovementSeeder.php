<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class InventoryMovementSeeder extends Seeder
{
    public function run()
    {
        // Obtener todos los productos y almacenes
        $products = DB::table('products')->pluck('id')->toArray();
        $warehouses = DB::table('warehouses')->pluck('id')->toArray();
        
        $movements = [];
        $movementTypes = ['IN', 'OUT'];
        $references = [
            'IN' => [
                'Compra a proveedor',
                'Transferencia entre almacenes',
                'Devolución de cliente',
                'Stock inicial',
                'Reposición automática',
                'Pedido urgente',
                'Importación',
                'Producción interna',
                'Ajuste de inventario positivo',
                'Recuperación de merma'
            ],
            'OUT' => [
                'Venta online',
                'Venta en tienda',
                'Transferencia a otro almacén',
                'Devolución a proveedor',
                'Producto defectuoso',
                'Muestra para cliente',
                'Promoción',
                'Regalo corporativo',
                'Ajuste de inventario negativo',
                'Merma por almacenamiento'
            ]
        ];

        // Generar 200 movimientos realistas
        for ($i = 0; $i < 200; $i++) {
            $type = $movementTypes[array_rand($movementTypes)];
            $productId = $products[array_rand($products)];
            $warehouseId = $warehouses[array_rand($warehouses)];
            
            // Cantidades más realistas según el tipo
            if ($type === 'IN') {
                $quantity = rand(5, 50); // Entradas más grandes
            } else {
                $quantity = rand(1, 15); // Salidas más pequeñas
            }
            
            // Fechas distribuidas en los últimos 6 meses
            $daysAgo = rand(1, 180);
            $movedAt = Carbon::now()->subDays($daysAgo)->addHours(rand(8, 18))->addMinutes(rand(0, 59));
            
            $reference = $references[$type][array_rand($references[$type])];
            
            $movements[] = [
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
                'type' => $type,
                'quantity' => $quantity,
                'reference' => $reference,
                'moved_at' => $movedAt,
            ];
        }

        // Asegurar que cada producto tenga al menos un movimiento IN para tener stock
        foreach ($products as $productId) {
            $hasEntry = collect($movements)->where('product_id', $productId)->where('type', 'IN')->count() > 0;
            
            if (!$hasEntry) {
                $warehouseId = $warehouses[array_rand($warehouses)];
                $movements[] = [
                    'product_id' => $productId,
                    'warehouse_id' => $warehouseId,
                    'type' => 'IN',
                    'quantity' => rand(10, 30),
                    'reference' => 'Stock inicial garantizado',
                    'moved_at' => Carbon::now()->subDays(rand(30, 90)),
                ];
            }
        }

        // Insertar todos los movimientos
        foreach (array_chunk($movements, 50) as $chunk) {
            DB::table('inventory_movements')->insert($chunk);
        }
    }
}
