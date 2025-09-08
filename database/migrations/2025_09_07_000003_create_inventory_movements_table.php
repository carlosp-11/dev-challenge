<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInventoryMovementsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->enum('type', ['IN', 'OUT']);
            $table->unsignedInteger('quantity');
            $table->string('reference')->nullable();
            $table->timestamp('moved_at');
            $table->index(['product_id', 'warehouse_id', 'moved_at']);
        });

        DB::table('inventory_movements')->insert([
            [
                'product_id' => 1,
                'warehouse_id' => 1,
                'type' => 'IN',
                'quantity' => 100,
                'reference' => 'Stock inicial',
                'moved_at' => now(),
            ],
        ]);

        DB::table('inventory_movements')->insert([
            [
                'product_id' => 2,
                'warehouse_id' => 2,
                'type' => 'IN',
                'quantity' => 50,
                'reference' => 'Stock inicial',
                'moved_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('inventory_movements');
    }
}
