<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWarehousesTable extends Migration
{
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('warehouses')->insert([
            ['code' => 'CAN-01', 'name' => 'Canarias 01'],
        ]);

        DB::table('warehouses')->insert([
            ['code' => 'MAD-01', 'name' => 'Madrid 01'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
