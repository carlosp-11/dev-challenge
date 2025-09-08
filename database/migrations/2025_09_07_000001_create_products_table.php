<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->unique();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('products')->insert([
            ['sku' => 'COL-135', 'name' => 'Colchón 135x190'],
        ]);

        DB::table('products')->insert([
            ['sku' => 'COL-150', 'name' => 'Colchón 150x190'],
        ]);

        DB::table('products')->insert([
            ['sku' => 'COL-160', 'name' => 'Colchón 160x190'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
