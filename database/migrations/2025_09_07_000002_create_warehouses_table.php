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
            ['code' => 'TNF-01', 'name' => 'Tenerife'],
            ['code' => 'GC-01', 'name' => 'Gran Canaria'],
            ['code' => 'MAD-01', 'name' => 'Madrid'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
